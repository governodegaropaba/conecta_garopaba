
(function ($) {
    "use strict";


    /*==================================================================
    [ Focus input ]*/
    $('.input100').each(function () {
        $(this).on('blur', function () {
            if ($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })
    })


    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit', function () {
        console.log('chegou');
        var check = true;

        for (var i = 0; i < input.length; i++) {
            if (validate(input[i]) == false) {
                showValidate(input[i]);
                check = false;
            }
        }
        console.log('validou');
        // Se algum campo não for preenchido, retorna o erro
        if (!check) {
            console.log('faltou campo');
            return check;
        }

        console.log('formatando dados');
        var objSerialize = adaptForm();

        console.log('vai executar ajax');
        if ($('.validate-form input[name="name"]').length > 0) {
            console.log('CRIAR CONTA');
            // Criar conta
            return sendCreateAccount(objSerialize);
        } else {
            console.log('FAZER LOGIN');
            // Realizar login
            return sendUserLogin(objSerialize);

        }
        return false;
    });


    $('.validate-form .input100').each(function () {
        $(this).focus(function () {
            hideValidate(this);
        });
    });

    function validate(input) {
        if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        } else if ($(input).attr('name') == 'username') { // CPF 
            if ($(input).val().length < 14) { // XXX.XXX.XXX-XX
                return false;
            }
        } else if ($(input).attr('name') == 'password') { // Data Nasc
            if ($(input).val().length < 10) { // XX/XX/XXXX
                return false;
            }        
        } else {
            if ($(input).val().trim() == '') {
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    /**
     * Ajusta o formulário, removendo pontuações e normalizando dados.
     * Realizado no front devido ao envio para o MK.
     */
    function adaptForm() {
        var objSerialize = $('.validate-form').serializeArray();
        objSerialize.forEach(function (e) {
            console.log(e.name, e.value);
            if (e.name == 'username') { // Formatando CPF
                e.value = e.value.replaceAll('.', '').replaceAll('-', '');
            } else if (e.name == 'password') { // Formatando data de nascimento
                var eTemp = e.value.split('/');
                e.value = eTemp[2] + '-' + eTemp[1] + '-' + eTemp[0];
            }
        });
        console.log('Formatado', objSerialize);
        return objSerialize;
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }

    function sendCreateAccount(obj) {
        console.log('CREATE', $('.validate-form').serializeArray());
        if ($('input[name="auth"]').prop('checked') == false) {
            showMsgReturn('Aceite os termos de uso para continuar');
            return false;
        }
        
        var formData = new ieFormData();
        formData.append('content', JSON.stringify(obj));
        formData.append('task', 'create_user');

        $.ajax({
            url: '../controller/user.php',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            async: false,
            processData: formData.processData,
            contentType: formData.contentType,
            success: function (data) {
                console.log('DEU CERTO!', data);
                showMsgReturn(data.msg_result);

                // Erro.
                if (data.result === "ERROR") {                    
                    return false;
                }

                // Exibe mensagem de sucesso e redireciona para login
                setTimeout(window.location.href = 'index.html', 3000);
            },
            error: function (obj, strStatus, strError) {
                showMsgReturn('Desculpe, ocorreu um erro (Cod.: USR99)');
                console.error('sendUserLogin => ERROR | obj: ', obj, ' | status: ', strStatus, ' | statusMsg: ', strError);
                return false;
            }
        });
        return false;
    }

    function sendUserLogin(obj) {
        console.log('LOGIN', obj);
        var formData = new ieFormData();
        formData.append('content', JSON.stringify(obj));
        formData.append('task', 'login_user');

        $.ajax({
            url: '../controller/user.php',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            async: false,
            processData: formData.processData,
            contentType: formData.contentType,
            success: function (data) {
                console.log('DEU CERTO!', data);
                // Erro. Exibe mensagem de retorno
                if (data.result === "ERROR") {
                    showMsgReturn(data.msg_result);
                    return false;
                }
                // Vai realizar a consulta no MK
                checkLoginMK(obj);
                return true;
            },
            error: function (obj, strStatus, strError) {
                showMsgReturn('Desculpe, ocorreu um erro (Cod.: USR99)');
                console.error('sendUserLogin => ERROR | obj: ', obj, ' | status: ', strStatus, ' | statusMsg: ', strError);
                return false;
            }
        });
        return false;
    }

    function checkLoginMK(obj) {
        console.log('CHECK LOGIN MK');
        $.ajax({
            url: 'http://192.168.45.1/login',
            type: 'POST',
            data: obj,
            cache: false,
            async: false,
            success: function (data) {
                console.log('RETORNO SUCESS', data);
                window.location.href = 'welcome.html';
                return true;
            },
            error: function (obj, strStatus, strError) {
                //showMsgReturn('Desculpe, ocorreu um erro (Cod.: USR98)');
                window.location.href = 'welcome.html';
                //console.error('checkLoginMK => ERROR | obj: ', obj, ' | status: ', strStatus, ' | statusMsg: ', strError);
                return true;
            }
        });
        return false;
    }

    function showMsgReturn(msg) {
        $("#login-msg-return").html(msg).fadeTo(4000, 500).slideUp(500, function () {
            $("#login-msg-return").slideUp(500);
        });
    }

})(jQuery);

function applyCPFMask(i) {
    var v = i.value;

    if (isNaN(v[v.length - 1])) {
        i.value = v.substring(0, v.length - 1);
        return;
    }

    i.setAttribute("maxlength", "14");
    if (v.length == 3 || v.length == 7) i.value += ".";
    if (v.length == 11) i.value += "-";
}

function applyDataNascMask(i) {
    var v = i.value;

    if (isNaN(v[v.length - 1])) {
        i.value = v.substring(0, v.length - 1);
        return;
    }

    i.setAttribute("maxlength", "10");
    if (v.length == 2 || v.length == 5) i.value += "/";
}

/**
 * Exibe o modal com os termos de uso
 */
function openTermsModal() {
    $('#termsModal').modal();
}

// Função responsável por definir um FormData para IE 9 e 10
// Utilizado como padrão nas chamadas AJAX
var ieFormData = function ieFormData() {
    if (window.FormData === undefined) {
        this.processData = true;
        this.contentType = 'application/x-www-form-urlencoded';
        this.append = function (name, value) {
            this[name] = value === undefined ? "" : value;
            return true;
        };
    } else {
        var formdata = new FormData();
        formdata.processData = false;
        formdata.contentType = false;
        return formdata;
    }
}