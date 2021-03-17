
// Передача параметров в модальное окно для удаления записи
$("body").on('click', '#checkBody', function (event) {
    const click = event.target
    const parent = click.closest("tr")
    if (parent.classList.contains("bg-secondary")) {
        console.log(parent)
        parent.classList.remove('bg-secondary')
        $('#modalDell').attr('disabled', true)
        $('#edit').attr('disabled', true)
    } else {
        $("#checkBody tr").each(function () {
            $(this).removeClass("bg-secondary")
            parent.classList.add("bg-secondary")
            const id = parent.getAttribute('data-id')
            $('#modalDell').attr({'data-id': id})
            $('#edit').attr({'data-id': id})
            $('#modalDell').attr('disabled', false)
            $('#edit').attr('disabled', false)
            $('#dellButton').attr({'data-id': id})
        })
    }


})

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
        data: {id: id},
        success: function () {
            // Закрытие модального окна
            $("#dellModal").modal('hide')
            //Перезагрузка вывода рееста
            $("#table").load(location.href + " #table")
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
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/edit/' + id,
        data: {id: id},
        success: function () {
            location.href = '/edit/' + id;
        },
        error: function () {
            alert('Ошибка')
        }
    })
}
// Календарь
$(function() {
    $("#date_start").datepicker($.datepicker.regional["ru"]);
});
$(function() {
    $("#date_finish").datepicker($.datepicker.regional["ru"]);
});

//Отображение формы поиска
$("#findFormButton").on('click', function () {
    $("#findForm").toggleClass('d-none')
})
// Задание серого background'а и border'а для активного span пагинации
$(document).ready(function(){
    $('li.active>span').addClass("bg-secondary border-dark")
});



