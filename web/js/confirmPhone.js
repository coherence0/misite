$(document).ready(function() {
    $('#findedDronePhoneForm').on('beforeSubmit', function() {
        // Получаем объект формы
        var $testform = $(this);
        // отправляем данные на сервер
        $.ajax({
            // Метод отправки данных (тип запроса)
            type : $testform.attr('method'),
            // URL для отправки запроса
            url : $testform.attr('action'),
            // Данные формы
            data : $testform.serializeArray()
        }).done(function(data) {
            console.log(data.data);
                if (data.error == null) {
                    // Если ответ сервера успешно получен
                    $("#output").text(data.data)
                } else {
                    // Если при обработке данных на сервере произошла ошибка
                    $("#output").text(data.error)
                }
        }).fail(function() {
            // Если произошла ошибка при отправке запроса
            $("#output").text("error3");
        })
        // Запрещаем прямую отправку данных из формы
        return false;
    })
})