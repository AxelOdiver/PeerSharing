// Schedule page - availability picker
$(document).ready(function() {
  const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
  const storageKey = 'weekly-availability';
  const $weekTiles = $('#weekTiles');
  const modalEl = document.getElementById('availabilityModal');
  const modal = new bootstrap.Modal(modalEl);

  const $selectedDayIndex = $('#selectedDayIndex');
  const $selectedDayLabel = $('#selectedDayLabel');
  const $startTimeInput = $('#startTime');
  const $endTimeInput = $('#endTime');
  const $form = $('#availabilityForm');
  const $clearTimeBtn = $('#clearTimeBtn');

  let availability = loadAvailability();

  function loadAvailability() {
    try {
      const saved = localStorage.getItem(storageKey);
      return saved ? JSON.parse(saved) : {};
    } catch (e) {
      return {};
    }
  }

  function saveAvailability() {
    localStorage.setItem(storageKey, JSON.stringify(availability));
  }

  function formatTime(time24) {
    if (!time24) return '';

    const parts = time24.split(':');
    let hour = parseInt(parts[0], 10);
    const minute = parts[1];
    const ampm = hour >= 12 ? 'PM' : 'AM';

    hour = hour % 12 || 12;

    return hour + ':' + minute + ' ' + ampm;
  }

  function getDisplayRange(dayIndex) {
    const data = availability[dayIndex];

    if (!data || !data.start || !data.end) {
      return '';
    }

    return formatTime(data.start) + ' - ' + formatTime(data.end);
  }

  function renderTiles() {
    $weekTiles.empty();

    $.each(days, function(index, day) {
      const range = getDisplayRange(index);
      const hasAvailability = !!range;

      const tileHtml = `
        <div class="col">
          <div class="availability-tile ${hasAvailability ? 'active' : ''}" data-day-index="${index}">
            <div>
              <div class="availability-day">${day}</div>
              <div class="availability-status">${hasAvailability ? 'Available' : 'No time selected'}</div>
            </div>
            <div class="availability-time ${hasAvailability ? '' : 'availability-empty'}">
              ${hasAvailability ? range : 'Tap to set time'}
            </div>
          </div>
        </div>
      `;

      $weekTiles.append(tileHtml);
    });
  }

  function openModal(dayIndex) {
    const existing = availability[dayIndex] || {};

    $selectedDayIndex.val(dayIndex);
    $selectedDayLabel.val(days[dayIndex]);
    $startTimeInput.val(existing.start || '');
    $endTimeInput.val(existing.end || '');

    modal.show();
  }

  $weekTiles.on('click', '.availability-tile', function() {
    const dayIndex = $(this).data('day-index');
    openModal(dayIndex);
  });

  $form.on('submit', function(e) {
    e.preventDefault();

    const dayIndex = $selectedDayIndex.val();
    const start = $startTimeInput.val();
    const end = $endTimeInput.val();

    if (!start || !end) {
      return;
    }

    if (start >= end) {
      toast('error', 'End time must be later than start time');
      return;
    }

    availability[dayIndex] = {
      start: start,
      end: end
    };

    saveAvailability();
    renderTiles();
    modal.hide();
    toast('success', 'Availability saved');
  });

  $clearTimeBtn.on('click', function() {
    const dayIndex = $selectedDayIndex.val();

    delete availability[dayIndex];
    saveAvailability();
    renderTiles();
    modal.hide();
  });

  renderTiles();
});
