$(function ($) {
  var pr = $(".phonesRepeater");
  var phones = pr.data('phones');
  pr.repeater({
    initEmpty: phones.length ? false : true,
    defaultValues: {
      'text-input': ''
    },
    show: function () {
      $(this).slideDown();
    },
    hide: function (deleteElement) {
      if(confirm('Are you sure you want to delete this element?')) {
        $(this).slideUp(deleteElement);
      }
    },
    ready: function (setIndexes) {},
    isFirstItemUndeletable: false
  });

  var er = $(".emailRepeater");
  var emails = er.data('email');
  er.repeater({
    initEmpty: emails.length ? false : true,
    defaultValues: {
      'text-input': ''
    },
    show: function () {
      $(this).slideDown();
    },
    hide: function (deleteElement) {
      if(confirm('Are you sure you want to delete this element?')) {
        $(this).slideUp(deleteElement);
      }
    },
    ready: function (setIndexes) {},
    isFirstItemUndeletable: false
  });

  var wr = $(".websiteRepeater");
  var websites = wr.data('website');
  wr.repeater({
    initEmpty: websites.length ? false : true,
    defaultValues: {
      'text-input': ''
    },
    show: function () {
      $(this).slideDown();
    },
    hide: function (deleteElement) {
      if(confirm('Are you sure you want to delete this element?')) {
        $(this).slideUp(deleteElement);
      }
    },
    ready: function (setIndexes) {},
    isFirstItemUndeletable: false
  });

  $('#companySubmit').on('click', function() {
    var emails = [];
    var er = $(".emailRepeater").repeaterVal();
    er.email.forEach(function(element) {
      emails.push(element.email);
    });
    $('#email').val(JSON.stringify(emails));

    var phones = [];
    var pr = $(".phonesRepeater").repeaterVal();
    pr.phones.forEach(function(element) {
      phones.push(element.phones);
    });
    $('#phones').val(JSON.stringify(phones));

    var websites = [];
    var wr = $(".websiteRepeater").repeaterVal();
    wr.website.forEach(function(element) {
      websites.push(element.website);
    });
    $('#website').val(JSON.stringify(websites));
  });
});