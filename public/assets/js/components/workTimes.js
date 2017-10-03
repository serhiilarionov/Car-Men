$(function ($) {
  var wt = $("#workTime");
  var workTimes = wt.data('work-times');
  var flags = {
    lunch: false,
    copyActive: false
  };

  var changeOneTimePicker = function (dayIndex) {
    $(dayIndex.currentTarget).parents('.dayContainer').each(function (index, element) {
      if(dayIndex.currentTarget.name === 'startTime') {
        workTimes[element.id]['timeFrom'] = dayIndex.currentTarget.value;
      } else if(dayIndex.currentTarget.name === 'endTime') {
        workTimes[element.id]['timeTill'] = dayIndex.currentTarget.value;
      } else if(dayIndex.currentTarget.name === 'lunchStartTime') {
        workTimes[element.id]['lunchTimeFrom'] = dayIndex.currentTarget.value;
      } else if(dayIndex.currentTarget.name === 'lunchEndTime') {
        workTimes[element.id]['lunchTimeTill'] = dayIndex.currentTarget.value;
      }
    });
  };
  var changeTimePickerRow = function (dayIndex) {
    var element = dayIndex.currentTarget;
    var currentTimePickers = $('[name='+ element.name +']');

    currentTimePickers.val(element.value);
    currentTimePickers.parents('.dayContainer').has( ".WorkingDayState" ).each(function(id, element) {
      if(dayIndex.currentTarget.name === 'startTime') {
        workTimes[element.id]['timeFrom'] = dayIndex.currentTarget.value;
      } else if(dayIndex.currentTarget.name === 'endTime') {
        workTimes[element.id]['timeTill'] = dayIndex.currentTarget.value;
      } else if(dayIndex.currentTarget.name === 'lunchStartTime') {
        workTimes[element.id]['lunchTimeFrom'] = dayIndex.currentTarget.value;
      } else if(dayIndex.currentTarget.name === 'lunchEndTime') {
        workTimes[element.id]['lunchTimeTill'] = dayIndex.currentTarget.value;
      }
    })
  };

  $("#copyCheckBox").on("click", function () {
    var startTime = $('[name="startTime"]');
    var endTime = $('[name="endTime"]');
    var lunchStartTime = $('[name="lunchStartTime"]');
    var lunchEndTime = $('[name="lunchEndTime"]');

    flags.copyActive = !flags.copyActive;
    if (flags.copyActive) {
      startTime.on('change', changeTimePickerRow);
      endTime.on('change', changeTimePickerRow);
      lunchStartTime.on('change', changeTimePickerRow);
      lunchEndTime.on('change', changeTimePickerRow);
      startTime.unbind('change', changeOneTimePicker);
      endTime.unbind('change', changeOneTimePicker);
      lunchStartTime.unbind('change', changeOneTimePicker);
      lunchEndTime.unbind('change', changeOneTimePicker);
    }
    else {
      startTime.unbind('change', changeTimePickerRow);
      endTime.unbind('change', changeTimePickerRow);
      lunchStartTime.unbind('change', changeTimePickerRow);
      lunchEndTime.unbind('change', changeTimePickerRow);
      startTime.on('change', changeOneTimePicker);
      endTime.on('change', changeOneTimePicker);
      lunchStartTime.on('change', changeOneTimePicker);
      lunchEndTime.on('change', changeOneTimePicker);
    }
  });


  $("#lunchCheckBox").on("click", function () {
    var dayContainers = $('.dayContainer');
    var days = dayContainers.has(".WorkingDayState");

    flags.lunch = !flags.lunch;
    if (flags.lunch) {
      dayContainers.has( ".WorkingDayState" ).find('[name="lunchStartTime"]').val(defaultOperationLunchTimeFrom);
      dayContainers.has( ".WorkingDayState" ).find('[name="lunchEndTime"]').val(defaultOperationLunchTimeTill);

      dayContainers.has( ".WorkingDayState" ).find('.lunch').show();
      dayContainers.has( ".WorkingDayState" ).find('.lunch').show();

      days.each(function(index, element) {
        workTimes[element.id].lunchTimeFrom = defaultOperationLunchTimeFrom;
        workTimes[element.id].lunchTimeTill = defaultOperationLunchTimeTill;
      })
    }
    else {
      dayContainers.has( ".WorkingDayState" ).find('[name="lunchStartTime"]').val(null);
      dayContainers.has( ".WorkingDayState" ).find('[name="lunchEndTime"]').val(null);

      dayContainers.has( ".WorkingDayState" ).find('.lunch').hide();
      dayContainers.has( ".WorkingDayState" ).find('.lunch').hide();

      days.each(function(index, element) {
        workTimes[element.id].lunchTimeFrom = null;
        workTimes[element.id].lunchTimeTill = null;
      })
    }
  });

  $('#companySubmit').on('click', function() {
    $('#work_time').val(JSON.stringify(workTimes));
  });

  var defaultOperationTimeFrom = '9:00';
  var defaultOperationTimeTill = '18:00';
  var defaultOperationLunchTimeFrom = '13:00';
  var defaultOperationLunchTimeTill = '14:00';

  wt.businessHours({
    operationTime: workTimes,
    defaultOperationTimeFrom: defaultOperationTimeFrom,
    defaultOperationTimeTill: defaultOperationTimeTill,
    defaultOperationLunchTimeFrom: defaultOperationLunchTimeFrom,
    defaultOperationLunchTimeTill: defaultOperationLunchTimeTill,
    postInit: function () {
      wt.find('.operationTimeFrom, .operationTimeTill').timepicker({
        'timeFormat': 'H:i',
        'step': 60
      });

      var startTime = $('[name="startTime"]');
      var endTime = $('[name="endTime"]');
      var lunchStartTime = $('[name="lunchStartTime"]');
      var lunchEndTime = $('[name="lunchEndTime"]');
      startTime.on('change', changeOneTimePicker);
      endTime.on('change', changeOneTimePicker);
      lunchStartTime.on('change', changeOneTimePicker);
      lunchEndTime.on('change', changeOneTimePicker);

      var workTime = $("#workTime");
      workTime.on("click", '.colorBox.WorkingDayState', function (element) {
        var id = element.target.parentElement.id;
        workTimes[id].isActive = true;
        workTimes[id].timeFrom = defaultOperationTimeFrom;
        workTimes[id].timeTill = defaultOperationTimeTill;

        $(element.target.parentElement).find('[name="startTime"]').val(defaultOperationTimeFrom);
        $(element.target.parentElement).find('[name="endTime"]').val(defaultOperationTimeTill);
        if(flags.lunch) {
          workTimes[id].lunchTimeFrom = defaultOperationLunchTimeFrom;
          workTimes[id].lunchTimeTill = defaultOperationLunchTimeTill;

          $(element.target.parentElement).find('[name="lunchStartTime"]').val(defaultOperationLunchTimeFrom);
          $(element.target.parentElement).find('[name="lunchEndTime"]').val(defaultOperationLunchTimeTill);
          $(element.target.parentElement).has( ".WorkingDayState" ).find('.lunch').show()
        } else {
          $(element.target.parentElement).has( ".WorkingDayState" ).find('.lunch').hide()
        }
      });

      workTime.on("click", '.colorBox.RestDayState', function (element) {
        var id = element.target.parentElement.id;
        workTimes[id].isActive = false;
        workTimes[id].timeFrom = null;
        workTimes[id].timeTill = null;
        workTimes[id].lunchTimeFrom = null;
        workTimes[id].lunchTimeTill = null;

        $(element.target.parentElement).find('[name="startTime"]').val(null);
        $(element.target.parentElement).find('[name="endTime"]').val(null);
        $(element.target.parentElement).find('[name="lunchStartTime"]').val(null);
        $(element.target.parentElement).find('[name="lunchEndTime"]').val(null);
      });

      flags.lunch = workTimes[0].lunchTimeFrom || workTimes[1].lunchTimeFrom ||
        workTimes[2].lunchTimeFrom || workTimes[3].lunchTimeFrom || workTimes[4].lunchTimeFrom ||
        workTimes[5].lunchTimeFrom || workTimes[6].lunchTimeFrom ? true : false;
      if(flags.lunch) {
        $( '#lunchCheckBox' ).attr('checked','checked');
      } else {
        var dayContainers = $('.dayContainer');
        dayContainers.has( ".WorkingDayState" ).find('.lunch').hide();
        dayContainers.has( ".WorkingDayState" ).find('.lunch').hide();
      }

    },
    dayTmpl: '<div class="dayContainer">' +
    '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"/></div>' +
    '<div class="weekday"></div>' +
    '<div class="operationDayTimeContainer">' +
    '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""/></div>' +
    '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-moon-o"></i></span><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""/></div>' +
    '</div>' +
    '<div class="operationDayTimeContainer lunch">' +
    '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-coffee"></i></span><input type="text" name="lunchStartTime" class="mini-time form-control operationTimeFrom" value=""/></div>' +
    '<div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-coffee"></i></span><input type="text" name="lunchEndTime" class="mini-time form-control operationTimeTill" value=""/></div>' +
    '</div>' +
    '</div>'
  });

});