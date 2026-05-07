/**
 * Dashboard global search
 * Attaches to #globalSearch input and renders a dropdown of users + communities.
 */
$(document).ready(function () {
    const $input   = $('#globalSearch');
    const $wrapper = $('#searchWrapper');
    const $dropdown = $('#searchDropdown');
    let debounceTimer = null;

    if (!$input.length) return;

    // ── helpers ──────────────────────────────────────────────────────────────

    function renderDropdown(data) {
        const { users, communities } = data;
        const hasUsers       = users.length > 0;
        const hasCommunities = communities.length > 0;

        if (!hasUsers && !hasCommunities) {
            $dropdown.html(`
                <div class="search-empty">
                    <i class="bi bi-search me-2 opacity-50"></i>No results found
                </div>
            `).show();
            return;
        }

        let html = '';

        if (hasUsers) {
            html += `<div class="search-section-label">Students</div>`;
            users.forEach(u => {
                html += `
                <a href="${u.url}" class="search-item d-flex align-items-center gap-2 text-decoration-none">
                    <div class="search-avatar">${u.initials}</div>
                    <div class="search-item-text">
                        <div class="search-item-title">${escapeHtml(u.name)}</div>
                        <div class="search-item-sub">${escapeHtml(u.email)}</div>
                    </div>
                </a>`;
            });
        }

        if (hasCommunities) {
            html += `<div class="search-section-label ${hasUsers ? 'mt-1' : ''}">Communities</div>`;
            communities.forEach(c => {
                html += `
                <a href="${c.url}" class="search-item d-flex align-items-center gap-2 text-decoration-none">
                    <div class="search-avatar community-avatar"><i class="bi bi-diagram-3-fill"></i></div>
                    <div class="search-item-text">
                        <div class="search-item-title">${escapeHtml(c.name)}</div>
                        <div class="search-item-sub">${escapeHtml(c.subject)}</div>
                    </div>
                </a>`;
            });
        }

        $dropdown.html(html).show();
    }

    function showLoading() {
        $dropdown.html(`
            <div class="search-empty">
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>Searching…
            </div>
        `).show();
    }

    function hideDropdown() {
        $dropdown.hide().html('');
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // ── events ───────────────────────────────────────────────────────────────

    $input.on('input', function () {
        const q = $(this).val().trim();
        clearTimeout(debounceTimer);

        if (q.length < 2) {
            hideDropdown();
            return;
        }

        showLoading();

        debounceTimer = setTimeout(() => {
            $.ajax({
                url: '/search',
                method: 'GET',
                data: { q },
                success: renderDropdown,
                error: () => {
                    $dropdown.html(`
                        <div class="search-empty text-danger">
                            <i class="bi bi-exclamation-circle me-1"></i>Something went wrong.
                        </div>
                    `).show();
                },
            });
        }, 280);
    });

    // Close dropdown when clicking outside
    $(document).on('click', function (e) {
        if (!$wrapper[0].contains(e.target)) {
            hideDropdown();
        }
    });

    // Reopen on focus if there's text
    $input.on('focus', function () {
        if ($(this).val().trim().length >= 2) {
            $(this).trigger('input');
        }
    });

    // Keyboard navigation (Escape to close)
    $input.on('keydown', function (e) {
        if (e.key === 'Escape') {
            hideDropdown();
            $(this).blur();
        }
    });
});
