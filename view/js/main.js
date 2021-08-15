
(function ($) {
    "use strict";


    /*==================================================================
    [ Focus input ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
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
    
    $('.validate-form').on('submit',function(){
        console.log('chegou');
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }
        console.log('validou');
        // Se algum campo não for preenchido, retorna o erro
        if (!check) {
            console.log('faltou campo');
            return check;
        }
        
        console.log('vai executar ajax');
        var formData = new ieFormData();        
        formData.append('content', JSON.stringify($('.validate-form').serializeArray()));
        
        if ($('.validate-form input[name="name"]').length > 0) {
            console.log('CRIAR CONTA');
            // Criar conta
            sendCreateAccount(formData);
        } else {
            console.log('FAZER LOGIN');
            // Realizar login
            return sendUserLogin(formData);
            
        }
        return false;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }        

    function sendCreateAccount() {
        console.log('CREATE', $('.validate-form').serializeArray());        
    }

    function sendUserLogin(formData) {
        console.log('LOGIN', $('.validate-form').serializeArray());        
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
                 // Sucesso. Redireciona para tela de bem-vindo
                 window.location.href = 'welcome.html';
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

    function showMsgReturn(msg) {
        $("#login-msg-return").html(msg).fadeTo(4000, 500).slideUp(500, function(){
            $("#login-msg-return").slideUp(500);
        });        
    }

})(jQuery);

function applyCPFMask(i){
    var v = i.value;
    
    if(isNaN(v[v.length-1])){
       i.value = v.substring(0, v.length-1);
       return;
    }
    
    i.setAttribute("maxlength", "14");
    if (v.length == 3 || v.length == 7) i.value += ".";
    if (v.length == 11) i.value += "-";
 }

 function applyDataNascMask(i){
    var v = i.value;
    
    if(isNaN(v[v.length-1])){
       i.value = v.substring(0, v.length-1);
       return;
    }
    
    i.setAttribute("maxlength", "10");
    if (v.length == 2 || v.length == 5) i.value += "/";
 }

// Função responsável por definir um FormData para IE 9 e 10
// Utilizado como padrão nas chamadas AJAX
var ieFormData = function ieFormData() {
    if (window.FormData === undefined)
    {
        this.processData = true;
        this.contentType = 'application/x-www-form-urlencoded';
        this.append = function (name, value) {
            this[name] = value === undefined ? "" : value;
            return true;
        };
    } else
    {
        var formdata = new FormData();
        formdata.processData = false;
        formdata.contentType = false;
        return formdata;
    }
}