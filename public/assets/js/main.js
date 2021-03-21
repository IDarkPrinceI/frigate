
//Функция удалить
function dellCheck(event) {
    const dellButton = $('#dellButton')
    const id = dellButton.attr('data-id')
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/dell/' + id,
        type: 'delete',
        success: function () {
            // Закрытие модального окна
            $("#dellModal").modal('hide')
            //Перезагрузка вывода рееста
            $("#table").load(location.href + " #table")
            //проверка на наличие данных в таблице #checkBody
            checkData()
        },
        error: function () {
            alert('Ошибка')
        }
    })
}
//Функция редактировать
function editCheck() {
    const edit = $('#edit')
    const id = edit.attr('data-id')
    $.ajax({
        url: '/edit/' + id,
        success: function () {
            location.href = '/edit/' + id;
        },
        error: function () {
            alert('Ошибка')
        }
    })
}

// Календарь
$(function () {
    $("#date_start").datepicker($.datepicker.regional["ru"]);
});
$(function () {
    $("#date_finish").datepicker($.datepicker.regional["ru"]);
});

//Отображение формы поиска
$("#findFormButton").on('click', function () {
    $("#findForm").toggleClass('d-none')
})

// Задание серого background'а и border'а для активного span пагинации
$(document).ready(function () {
    $('li.active>span').addClass("bg-secondary border-dark")
});

//Проверка на наличие данных в таблице #checkBody
function checkData() {
    setTimeout(function () { // если удаляемый объект был последним на странице,
        if ($.trim($("#checkBody").text()) === '') {
            document.location.href = 'http://project/'; // то будет произведен redirect на главную
        }
    }, 500)
}

$("body")
    .on('click', "#dropDownObject", function (event) { //обработчик клика на выпадающий список при выборе СМП
        if (event.target.nodeName === 'LI') {
            $("#object").val(event.target.textContent)
            $("#dropDownObject, #divObject").removeClass('show') //закрыть выпадающий список
        }
    })
    .on('click', "#dropDownControl", function (event) { //обработчик клика на выпадающий список при выборе Контроля
        if (event.target.nodeName === 'LI') {
            $("#control").val(event.target.textContent)
            $("#dropDownControl, #divControl").removeClass('show') //закрыть выпадающий список
        }
    })
    .on('click', '#checkBody', function (event) { // Передача параметров в модальное окно для удаления записи
        const click = event.target
        const parent = click.closest("tr") //выбрать родительскую строчку в таблице
        if (parent.classList.contains("bg-secondary")) { //убрать старое выделение записи при клике
            parent.classList.remove('bg-secondary')
            $('#modalDell').attr('disabled', true) //заблокировать кнопку удалить
            $('#edit').attr('disabled', true) //заблокировать кнопку редактировать
        } else {
            $("#checkBody tr").each(function () {
                $(this).removeClass("bg-secondary") //убрать старое выделение записи при клике
                parent.classList.add("bg-secondary")
                const id = parent.getAttribute('data-id')
                $('#modalDell').attr({'data-id': id, 'disabled': false}) //активировать кнопку удалить/присвоить id для индефикации
                $('#edit').attr({'data-id': id, 'disabled': false}) //активировать кнопку редактировать/присвоить id для индефикации
                $('#dellButton').attr('data-id', id) // передача id в модальное окно для удаления записи
            })
        }
    })

$("#inputControl") //формирования выпадающего списка контроля при поиске
    .on('input keyup', function () {
        let data = ($(this).val())
        $.ajax({
            url: '/include/',
            data: {data: data,
                  type: 'control'},
            dataType: 'json',
            success: function (res) {
                $("#divControl").html(res.html) //вставка нового выпадающего списка
                $("#dropDownControl").addClass('show') //открыть выпадающий список
            },
            error: function () {
                console.log('Ошибка')
            }
        })
    })

$("#inputObject") //формирования выпадающего списка контроля при поиске
    .on('input keyup', function () {
        let data = ($(this).val())
        $.ajax({
            url: '/include/',
            data: {data: data,
                  type: 'object'},
            dataType: 'json',
            success: function (res) {
                $("#divObject").html(res.html) //вставка нового выпадающего списка
                $("#dropDownObject").addClass('show') //открыть выпадающий список
            },
            error: function () {
                console.log('Ошибка')
            }
        })
    })







