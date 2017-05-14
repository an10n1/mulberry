import { eraseCookie } from './modules/coreFunc.es6'

module.exports = (body) => {
  function ajaxApi (options) {
    if (['', null, undefined].indexOf(options.url) >= 0) { return false }
    if (['', null, undefined].indexOf(options.method) >= 0) { return false }

    if (['', null, undefined].indexOf(options.data) >= 0) { options.data = null }
    if (['', null, undefined].indexOf(options.before) >= 0) { options.before = () => {} }
    if (['', null, undefined].indexOf(options.success) >= 0) { options.success = () => {} }
    if (['', null, undefined].indexOf(options.error) >= 0) { options.error = () => {} }

    $.ajax({
      url: options.url,
      method: options.method,
      cache: false,
      data: options.data,
      dataType: 'json',
      beforeSend: () => {
        options.before()
      },
      success: (response) => {
        options.success(response)
      },
      error: (xhr) => {
        options.error(xhr)
      }
    })
  }

  function auth (status) {
    let sendData = null
    let successFn
    let errorFn
    let url

    if (status) {
      url = '/login'
      sendData = {
        login: $('[name="login"]').val(),
        password: $('[name="password"]').val()
      }
      successFn = () => {
        location.reload()
      }
      errorFn = () => {
        alert('Incorrect data!')
      }
    } else {
      url = '/logout'
      successFn = errorFn = () => {
        eraseCookie('admin_session.sig')
        location.href = '/'
      }
    }

    ajaxApi({
      url: url,
      method: 'POST',
      data: sendData,
      success: () => {
        successFn()
      },
      error: (xhr) => {
        errorFn()
      }
    })
  }

  function reponseModal (status, text, flag) {
    if (status) {
      $('.admin-modal').find('h3').text(text)
      $('.admin-modal').show()
      $('.admin-modal-backdrop').show()

      if (!flag) {
        setTimeout(() => {
          $('.admin-modal').hide()
          $('.admin-modal-backdrop').hide()
        }, 1000)
      }
    } else {
      $('.admin-modal').hide()
      $('.admin-modal-backdrop').hide()
    }
  }

  function updateAdmin (name) {
    let sendData = {
      name: $('[name="adminName"]').val(),
      addr: $('[name="adminAddr"]').val(),
      tel: $('[name="adminTel"]').val(),
      email: $('[name="adminEmail"]').val(),
      fb: $('[name="adminFB"]').val(),
      vk: $('[name="adminVK"]').val(),
      goo: $('[name="adminGoo"]').val()
    }

    ajaxApi({
      url: '/adminupdate/' + name,
      method: 'PUT',
      data: sendData,
      success: (response) => {
        reponseModal('show', 'Update successful')
      },
      error: (xhr) => {
        reponseModal('show', 'Error! Look at the console', 'dont close')
        console.log(xhr)
      }
    })
  }

  // Convert course filed string to object
  function trimCourseService (field) {
    let arr = field.val().split(',')
    let obj = arr.reduce(function (result, current, item) {
      result[item] = current
      return result
    }, {})

    return obj
  }

  function createData () {
    let sendData = {
      name: $('#new').find('[name="courseName"]').val(),
      time: $('#new').find('[name="courseTime"]').val(),
      services: trimCourseService($('#new').find('[name="courseService"]')),
      date: $('#new').find('[name="courseDate"]').val(),
      day: $('#new').find('[name="courseDay"]').val(),
      place: $('#new').find('[name="coursePlace"]').val(),
      coast: $('#new').find('[name="courseCoast"]').val(),
      descr: $('#new').find('[name="courseDescr"]').html(),
      lessons: trimCourseService($('#new').find('[name="courseLessons"]')),
      teacher: $('#new').find('[name="courseTeacher"] option:selected').attr('data-val')
    }

    ajaxApi({
      url: '/courses',
      method: 'POST',
      data: sendData,
      success: (response) => {
        reponseModal('show', 'Create complete')

        location.reload()
      },
      error: (xhr) => {
        reponseModal('show', 'Error! Look at the console', 'dont close')
        console.log(xhr)
      }
    })
  }

  function updateData (id) {
    let activeCourse = $('.tab-pane.active')
    let sendData = {
      name: activeCourse.find('[name="courseName"]').val(),
      time: activeCourse.find('[name="courseTime"]').val(),
      services: trimCourseService(activeCourse.find('[name="courseService"]')),
      date: activeCourse.find('[name="courseDate"]').val(),
      day: activeCourse.find('[name="courseDay"]').val(),
      place: activeCourse.find('[name="coursePlace"]').val(),
      coast: activeCourse.find('[name="courseCoast"]').val(),
      descr: activeCourse.find('[name="courseDescr"]').html(),
      lessons: trimCourseService(activeCourse.find('[name="courseLessons"]')),
      teacher: activeCourse.find('[name="courseTeacher"] option:selected').attr('data-val')
    }

    ajaxApi({
      url: '/courses/' + id,
      method: 'PUT',
      data: sendData,
      success: (response) => {
        reponseModal('show', 'Update successful')
      },
      error: (xhr) => {
        reponseModal('show', 'Error! Look at the console', 'dont close')
        console.log(xhr)
      }
    })
  }

  function removeData (id) {
    ajaxApi({
      url: '/courses/' + id,
      method: 'DELETE',
      success: (response) => {
        $('[href="#adminSettings"]').trigger('click')

        $('[href="#tab_' + id + '"]').remove()
        $('#tab_' + id).remove()

        reponseModal('show', 'Delete successful')
      },
      error: (xhr) => {
        reponseModal('show', 'Error! Look at the console', 'dont close')
        console.log(xhr)
      }
    })
  }

  function _dataPicker () {
    require('jquery-datetimepicker')
    $.datetimepicker.setLocale('en')

    $('[name="courseDate"]').datetimepicker({
      timepicker: false,
      format: 'd.m.Y'
    })
  }

  function _showDescrField (el) {
    if (el.hasClass('js-update-descr')) {
      el.closest('form').find('[name="courseDescr"]').toggleClass('is-active')
      el.closest('form').find('[name="courseDescr"] + .close-btn').toggleClass('is-active')
    } else if (el.hasClass('js-update-lessons')) {
      el.closest('form').find('[name="courseLessons"]').toggleClass('is-active')
      el.closest('form').find('[name="courseLessons"] + .close-btn').toggleClass('is-active')
    }

    if (el.hasClass('close-btn')) {
      el.closest('form').find('.js-is-contenteditable').removeClass('is-active')
      el.removeClass('is-active')
    }
  }

  function Event () {
    _dataPicker()

    body.on('click', '.js-update-descr, .js-update-lessons, .close-btn', function (e) {
      e.preventDefault()

      _showDescrField($(this))
    })

    body.on('click', '.js-update-admin', function (e) {
      e.preventDefault()

      updateAdmin($(this).data('name'))
    })

    body.on('click', '.js-update', function (e) {
      e.preventDefault()

      updateData($(this).data('id'))
    })

    body.on('click', '.js-remove', function (e) {
      e.preventDefault()

      removeData($(this).data('id'))
    })

    body.on('click', '.js-create', function (e) {
      e.preventDefault()

      createData()
    })

    body.on('click', '.js-currency', function (e) {
      e.preventDefault()
      let coastField = $(this).closest('.input-group').find('input')
      let coast = parseInt(coastField.val())

      coastField.val(coast + ' ' + $(this).text())
    })

    body.on('click', '.js-login', function (e) {
      e.preventDefault()

      auth(true)
    })

    body.on('click', '.js-logout', function (e) {
      e.preventDefault()

      auth(false)
    })
  }

  return {
    Event: Event
  }
}
