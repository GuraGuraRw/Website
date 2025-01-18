/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License 3.0 (AFL-3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/AFL-3.0
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to https://www.prestashop.com for more information.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2020 PrestaShop SA
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
* International Registered Trademark & Property of PrestaShop SA
*/

$(document).ready(function() {
    if ($('#chat_window_2 .ochat-footer textarea').length > 0) {
        $('.ochat-footer textarea').autoResize();
    }
    if (online == 1) {
        if (localStorage.getItem('ochat-customer_'+OCHAT_UNIQID) !== null) {
            var customer_data =  JSON.parse(localStorage.getItem('ochat-customer_'+OCHAT_UNIQID));
            if (id_customer != customer_data['id'] && id_guest != customer_data['id_guest']) {
                localStorage.removeItem('ochat-fo-thread_'+OCHAT_UNIQID);
                localStorage.removeItem('ochat-fo-message-list'+OCHAT_UNIQID);
                localStorage.removeItem('ochat-customer_'+OCHAT_UNIQID);
            }
        }
        initStorageMessageList();
    } else {
        cleanStorage();
        if (localStorage.getItem('ochat-fo-changement_'+OCHAT_UNIQID) == 1) {
            $('#disconnect-message').show();
            localStorage.removeItem('ochat-fo-changement_'+OCHAT_UNIQID);
            $(".ochat-panel-heading span.icon_minim").trigger("click");
        }
    }

    /* Like Hangout Chat */
    $(document).on('click', '.ochat-panel-heading', function (e) {
        var $this = $('.ochat-panel-heading span.icon_minim');
        if (!$this.hasClass('panel-collapsed')) {
            minimizedChat($this);
        } else {
            expendChat($this);
        }
        e.preventDefault();
    });

    /**
     * Reduce chat window
     */
    function minimizedChat() {
        var $this = $('.ochat-panel-heading span.icon_minim');
        $this.parents('.ochat-panel-default').find('.msg_container_base, .ochat-footer').slideUp();
        $this.addClass('panel-collapsed');
        $this.removeClass('fa-caret-down').addClass('fa-caret-up');
        localStorage.setItem('ochat-fo-min_'+OCHAT_UNIQID, true);
    }

    /**
     * Expend chat window
     */
    function expendChat() {
        var $this = $('.ochat-panel-heading span.icon_minim');
        $this.parents('.ochat-panel-default').find('.msg_container_base, .ochat-footer').slideDown();
        $this.removeClass('panel-collapsed');
        $this.removeClass('fa-caret-up').addClass('fa-caret-down');
        if (online == 1) {
            $('.msg_container_base').scrollTop($('.msg_container_base')[0].scrollHeight);
        }
        localStorage.setItem('ochat-fo-min_'+OCHAT_UNIQID, false);
    }

    /* Offline --------------------------------------*/
    /**
     * Offline form check
     */
    $(document).on('click', '#send-offline-form', function(e) {
        var form = $('#offlineForm').serializeArray();

        // ajax call to launch the send
        if (checkForm(form)) {
            $('#offlineForm .fa-send-o').addClass('fa-spinner fa-spin').removeClass('fa-send-o');
            $.ajax({
                type: 'POST',
                url: OCHAT_FRONT_CONTROLLER_URL,
                dataType: 'html',
                data: {
                    action : 'SendOfflineMessage',
                    ajax : true,
                    form : form
                },
                success : function(data) {
                    if (data == 1) {
                        $('#disconnect-message').hide();
                        $('#return-message').slideDown("slow");
                        $('#offlineForm').find("input[type=text], input[type=email], textarea").val("");
                        $(".form-group").removeClass('form-ok');
                        $('#offlineForm .fa-spinner').addClass('fa-send-o').removeClass('fa-spinner').removeClass('fa-spin');
                        $('.ochat-form-control').removeClass('valid-input');
                        $("#send-offline-form").addClass('cant-submit');
                    } else {
                        $('#return-message').hide();
                        $('#disconnect-message').slideDown("slow");
                        $('#offlineForm .fa-spinner').addClass('fa-send-o').removeClass('fa-spinner').removeClass('fa-spin');
                    }
                }
            });
        }
        $(this).blur();
        e.preventDefault();
    });

    /**
     * Check if the value is correct
     */
    $(document).on('focusout keyup live', '.offline-form .ochat-form-control', function() {
        input_id = $(this).attr('id');
        hidden_field = 1;

        if(input_id == 'OCHAT_FORM_EMAIL') {
            if (isEmail( $(this).val() ))
                $(this).addClass('valid-input').removeClass('not-valid-input');
            else
               $(this).removeClass('valid-input').addClass('not-valid-input');
        }
        else if(input_id == 'OCHAT_FORM_PHONE') {
            if (isPhone( $(this).val() ))
                $(this).addClass('valid-input').removeClass('not-valid-input');
            else
               $(this).removeClass('valid-input').addClass('not-valid-input');
        } else  {
            if ( $(this).val().length > 0 )
                $(this).addClass('valid-input').removeClass('not-valid-input');
            else
               $(this).removeClass('valid-input').addClass('not-valid-input');
        }

        let gdprCanSubmit = true;
        if (isThereGDPR()) {
            if (!$('.offline-form .psgdpr_consent_message input').is(':checked')) {
                gdprCanSubmit = false;
            }
        }

        if( ($('.ochat-form-control').length - hidden_field) != $('.valid-input').length ){
            $("#send-offline-form").addClass('cant-submit');
        }
        else{
            if (gdprCanSubmit)
                $("#send-offline-form").removeClass('cant-submit');
        }

    });

    $(document).on('click', '.gdprochat input', function(){
        $('.offline-form .ochat-form-control').trigger('focusout');
    });

    function isThereGDPR() {
        if ($('.offline-form .psgdpr_consent_message').length > 0) {
           return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the form is correct
     * @param form
     * @returns {boolean}
     */
    function checkForm(form) {
        var error = 0;
        $.each(form, function(i) {
            if (form[i]['name'] == "OCHAT_FORM_EMAIL") {
                if (!isEmail(form[i]['value'])) {
                    error += 1;
                }
            } else {
                if (form[i]['value'].length == 0) {
                    error += 1;
                }
            }
        });
        if( $("#send-offline-form").hasClass('cant-submit') ){
            error += 1;
        }
        if (error > 0) {
            return false;
        }
        return true;
    }

    /**
     * Check if it's email
     * @param email
     * @returns {boolean}
     */
    function isEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    /**
     * Check if it's phone
     * @param phone
     * @returns {boolean}
     */
    function isPhone( phone ) {
        var re = /^[\+0-9\-().\s]*$/;
        return re.test(phone);
    }

    /**
     * Create the message bleck then append it
     * @param is_send 1 == send message | 0 == recieve message
     * @param content
     * @param date
     * @param position
     * @param advisor
     * @returns {*|jQuery}
     */
    function createMessageBlock(is_send, content, date, position, advisor) {
        var elm = '';

        content = content.replace(/&amp;quot;/g, '"');

        // Send message
        if (is_send == 'true') {
            elm += '<div class="row msg_container base_sent" id="' + position + '">';
            elm += '<div class="col-2"></div><div class="col-10"><div class="messages msg_sent">';
            elm += '<p>' + content + '</p></div><time datetime="2009-11-13T20:00" class="customer_time">'+ date + '</time></div></div>';
        }
        // Recieve message
        else {
            elm += '<div class="row msg_container base_receive" id="' + position + '">';
            if (OCHAT_ADVISOR_IMAGE_TYPE == 'default') {
                elm += '<div class="ochat_advisor_img col-2"><i class="fa fa-user" aria-hidden="true"></i></div>';
            } else {
                elm += '<div class="ochat_advisor_img col-2"><img src="'+OCHAT_ADVISOR_IMAGE_SRC+'"/></i></div>';
            }
            elm += '<div class="col-9"><div class="messages msg_receive">';
            elm += '<p>' + content + '</p></div><time datetime="2009-11-13T20:00">'+ date + ' - <span class="ope_name">'+advisor+'</span></time></div>';
            elm += '</div>';
        }

        $('.msg_container_base').append(elm);

        saveMessageStorage(is_send, content, date, position, advisor);

        if (is_send == 'true') {
            $('.msg_container_base').scrollTop($('.msg_container_base')[0].scrollHeight);
            $('#btn-chat').addClass('ochat-disabled');
            $('#btn-input').val('');
        } else {
            $('.msg_container_base').scrollTop($('.msg_container_base')[0].scrollHeight);
            $('#btn-chat').addClass('ochat-disabled');
        }
    }

    /**
     * Check if the content to send is not null
     */
    function getCaret(el) {
        if (el.selectionStart) {
            return el.selectionStart;
        } else if (document.selection) {
            el.focus();
            var r = document.selection.createRange();
            if (r == null) {
                return 0;
            }
            var re = el.createTextRange(), rc = re.duplicate();
            re.moveToBookmark(r.getBookmark());
            rc.setEndPoint('EndToStart', re);
            return rc.text.length;
        }
        return 0;
    }
    $(document).on('keyup', '#btn-input', function(event) {
        if (event.keyCode == 13 && event.shiftKey) {
           var content = this.value;
           var caret = getCaret(this);
           this.value = content.substring(0,caret)+"\n"+content.substring(caret,content.length-1);
           event.stopPropagation();
        } else if(event.keyCode == 13) {
          $("#btn-chat").trigger("click");
        }

        if ($(this).val() == 0) {
            $('#btn-chat').addClass('ochat-disabled');
        }
        else {
            $('#btn-chat').removeClass('ochat-disabled');
        }
    });

    /**
     * Check if the thread exist if not create one and post the message
     * @param content
     */
    function postMessage(content) {
        var thread = $('.msg_container_base').attr('data-thread'),
            params = {},
            message = {};

        if (id_customer == null) {
            message = {
                message_content : content,
                id_guest : id_guest
            };
        } else {
            message = {
                message_content : content,
                id_customer : id_customer
            };
        }

        // No thread existing, create one
        if (thread.length == 0) {
            $.ajax({
                type: 'POST',
                url: OCHAT_FRONT_CONTROLLER_URL,
                dataType: 'html',
                data: {
                    action : 'CheckBeforeCreateThread',
                    ajax : true,
                    id_shop : id_shop,
                    timezone: $('#otimezone').val()
                },
                success: function(data) {
                    if (data == 1) {
                        createThread(message);
                    } else {
                        createMessageBlock('false', cant_create_thread_message, cant_create_thread_time, 0, OCHAT_ADVISOR_NAME);
                        setTimeout(function(){
                            window.location.reload();
                        }, 4000);
                    }
                }
            });
        } else {
            params = {
                thread : thread,
                message : message,
                timezone: $('#otimezone').val()
            };
            callJsonHandler('postMessage', params);
        }
    }

    /**
     * Create thread
     */
    function createThread(message) {
        var params = {};

        if (localStorage.getItem('ochat-customer_'+OCHAT_UNIQID) === null) {
            params = {
                id_shop : id_shop,
                id_lang : id_lang,
                id_customer : id_customer,
                id_guest : id_guest,
                id_employee : null,
                customer_name : null
            };
        } else {
            var customer_data =  JSON.parse(localStorage.getItem('ochat-customer_'+OCHAT_UNIQID));
            params = {
                id_shop : id_shop,
                id_lang : id_lang,
                id_customer : id_customer,
                id_guest : id_guest,
                id_employee : null,
                customer_name : customer_data['name']
            };
        }

        $.ajax({
            type: 'POST',
            url: json_handler_url,
            dataType: 'json',
            asynch : false,
            data: {
                ajax : true,
                action : 'createThread',
                params : params
            },
            success : function(data) {
                if (!data) {
                    $('#error-message.ochat-alert-warning').slideDown();
                } else {
                    $('#error-message.ochat-alert-warning').hide();
                    thread = data['thread'];
                    $('.msg_container_base').attr('data-thread', thread);
                    localStorage.setItem('ochat-fo-thread_'+OCHAT_UNIQID, thread);
                    params = {
                        thread : thread,
                        message : message
                    };
                    callJsonHandler('postMessage', params);
                    checkIfEmployee();
                    fetcher();
                }
            }
        });
    }

    /**
     * Clean the chat thread form previous messages
     */
    function cleanThread() {
        $('.msg_container_base').attr('data-thread', '');
        $('.ochat-closed-thread').show();
        $('.msg_container').remove();
    }

    /**
     * Send the content to the json file
     */
    $(document).on('click', '#btn-chat', function(e) {
        var content = $.trim($('#btn-input').val());

        if (content.length > 0) {
            postMessage(htmlEntities(content));
        }
        $(this).blur();
        e.preventDefault();
    });

    /**
     * Htmlentities fo js
     * @param str
     * @returns {string}
     */
    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    /**
     * Call JsonHandler Class
     * @param func
     * @param params
     */
    function callJsonHandler(func, params) {
        $.ajax({
            type: 'POST',
            url: json_handler_url,
            dataType: 'json',
            asynch : false,
            data: {
                ajax : true,
                action : func,
                params : params
            },
            success : function(data) {
                if (func == 'postMessage') {
                    if (data == null) {
                        cleanThread();
                        postMessage(params['message']['message_content']);
                    }
                    else {
                        createMessageBlock('true', params['message']['message_content'], data['date'].substring(11), data['position'], 'Me');
                    }
                }
            }
        });
    }

    /**
     * Save message in local Storage
     * @param is_send
     * @param content
     * @param date
     * @param position
     * @param advisor
     */
    function saveMessageStorage(is_send, content, date, position, advisor) {
        var data = null;

        if (localStorage.getItem('ochat-fo-message-list'+OCHAT_UNIQID) === null) {
            data = {};
        } else {
            data = JSON.parse(localStorage.getItem('ochat-fo-message-list'+OCHAT_UNIQID));
        }
        data[position] = {
            is_send: is_send,
            content: content,
            date: date,
            position: position,
            advisor: advisor
        };
        localStorage.setItem('ochat-fo-message-list'+OCHAT_UNIQID, JSON.stringify(data));
    }

    /**
     * Get storaged message list then add then to the list
     */
    function initStorageMessageList() {
        if (localStorage.getItem('ochat-fo-thread_'+OCHAT_UNIQID) != null &&  localStorage.getItem('ochat-fo-message-list'+OCHAT_UNIQID) != null) {
            var data = JSON.parse(localStorage.getItem('ochat-fo-message-list'+OCHAT_UNIQID));

            $('.msg_container_base').attr('data-thread', localStorage.getItem('ochat-fo-thread_'+OCHAT_UNIQID));

            $.each(data, function(i, v){
                createMessageBlock(v['is_send'], v['content'], v['date'], i, v['advisor']);
            });

            if (localStorage.getItem('ochat-fo-min_'+OCHAT_UNIQID) == "false") {
                expendChat();
            }
            checkIfEmployee();
            fetcher();
        }
        if (typeof customer_id != 'undefined' && localStorage.getItem('ochat-customer_'+OCHAT_UNIQID) == null) {
            var ochat_customer = {
                id : customer_id,
                id_guest : customer_id_guest,
                name : customer_name,
                email : customer_email
            };
            localStorage.setItem('ochat-customer_'+OCHAT_UNIQID, JSON.stringify(ochat_customer));
        }
    }

    /**
     * Clear the storage if it exists
     */
    function cleanStorage() {
        localStorage.clear();
        if (localStorage.getItem('ochat-fo-thread_'+OCHAT_UNIQID) !== null) {
            localStorage.removeItem('ochat-fo-thread_'+OCHAT_UNIQID);
            localStorage.removeItem('ochat-fo-message-list'+OCHAT_UNIQID);
            localStorage.removeItem('ochat-customer_'+OCHAT_UNIQID);
            localStorage.setItem('ochat-fo-changement_'+OCHAT_UNIQID, 1);
        } else {
            localStorage.removeItem('ochat-customer_'+OCHAT_UNIQID);
            localStorage.setItem('ochat-fo-changement_'+OCHAT_UNIQID, 0);
        }
    }

    /**
     * Get new message from json
     */
    function fetcher() {
        var params = {
            thread : localStorage.getItem('ochat-fo-thread_'+OCHAT_UNIQID),
            message_key : $('.messages').length - 1,
            id_customer : id_customer,
            id_guest : id_guest
        };

        $.ajax({
            type: 'POST',
            url: json_handler_url,
            dataType: 'json',
            asynch : false,
            data: {
                ajax : true,
                action : 'getEmployeeLastMessages',
                params : params
            },
            success: function(data) {
                if (data != null) {
                    $.each(data['message_list'], function(i, v) {
                        $('#ochat_window_open .open_ochat_window').trigger('click');
                        let content = v['message_content'].replace(/&amp;quot;/g, '"');
                        createMessageBlock('false', v['message_content'], v['message_date'].substring(11), $('.messages').length, v['employee_name']);
                    });
                }
            },
            error: function(data) {
                cleanStorage();
                location.reload(); // Bad, bad, verry bad
            },
            complete: function() {
                setTimeout(fetcher, OCHAT_TIME_DELAY); // Schedule the next request when the current one's complete
            }
        });
    }

    /**
     * Check if there is an employee connected
     */
    function checkIfEmployee() {
        $.ajax({
            type: 'POST',
            url: OCHAT_FRONT_CONTROLLER_URL,
            dataType: 'html',
            data: {
                action : 'IsEmployeeConnected',
                ajax : true
            },
            success: function(data) {
                if (data == 0) {
                    if (localStorage.getItem('ochat-fo-thread_'+OCHAT_UNIQID) != null) {
                        location.reload(); // Bad, bad, verry bad
                    }
                }
            },
            complete: function() {
                setTimeout(checkIfEmployee, 10000); // Schedule the next request when the current one's complete
            }
        });
    }

    /**
     * Close chat
     */
    $(document).on('click', '.ochat-chat .ochat-close-p', function (e) {
        var thread = $(this).parents('.ochat-chat').attr('data-thread'),
            elm = $(this);

        swal({
            title: title_closed_thread,
            text: text_closed_thread,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: text_closed_thread_confirm_button,
            cancelButtonText: cancel_button,
            closeOnConfirm: false},
            function() {
                closeThread(thread, elm);
            }
       );
        e.preventDefault();
    });

});

$(document).on('click', '#ochat_window_open span', function(){
    if ($(this).hasClass('close_ochat_window')) {
        $('.chat-window').slideUp();
        $('#ochat_window_open span.open_ochat_window').show();
        $('#ochat_window_open span.close_ochat_window').hide();

    } else {
        $('.chat-window').slideDown();
        $('#ochat_window_open span.close_ochat_window').show();
        $('#ochat_window_open span.open_ochat_window').hide();
        $('#hello_text-offline, #hello_text-online').hide();
        $('.ochat-footer textarea').focus();
    }
});