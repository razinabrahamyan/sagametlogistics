let AlertNotification = new (function () {
    this.alertTarget = undefined;
    this.notificationSoundPath = window.location.origin + '/audio/notification.wav';

    this.alertSuccess = function (message, hideTimeOut = 5000) {
        //Убираем старый блок
        $('#alert_success').remove();

        //Подготовка внедрения оповещения
        let desk = $('<div class="alert_div animate__animated card" id="alert_success" onclick="AlertNotification.closeNotificationBlock()">' +
            '<p class="mb-0" id="alert_message">' + message + '</p>' +
            '</div>');
        AlertNotification.alertTarget = desk;

        //Запускаем анимацию
        $('.app-content').prepend(desk);
        desk.show().addClass('animate__fadeInDown');

        //Если укзано время то запускаем таймер закрытия
        if (hideTimeOut > 0) {
            setTimeout(function () {
                AlertNotification.closeNotificationBlock(desk);
            }, hideTimeOut)
        }
    };

    this.closeNotificationBlock = function () {
        if (AlertNotification.alertTarget !== undefined) {
            AlertNotification.alertTarget.removeClass('animate__fadeInDown').addClass('animate__bounceOutRight')
            AlertNotification.alertTarget = undefined;
        }
    };

    this.playSound = function (url) {
        let mute = localStorage.getItem('mute');
        if (mute === null || mute === 'on') {
            const audio = new Audio(url);
            audio.play();
        }
    };

    this.muteSoundTrigger = function () {
        let mute = (localStorage.getItem('mute') == null || localStorage.getItem('mute') === 'on') ? 'off' : 'on';
        localStorage.setItem('mute', mute);
        AlertNotification.muteSoundTriggerIconTrigger();
    };

    this.muteSoundTriggerIconTrigger = function () {
        let mute = (localStorage.getItem('mute') == null || localStorage.getItem('mute') === 'on') ? 'off' : 'on';
        if (mute === 'on') {
            $('#mute-off').addClass('d-none').removeClass('d-block');
            $('#mute-on').addClass('d-block').removeClass('d-none');
        } else {
            $('#mute-off').addClass('d-block').removeClass('d-none');
            $('#mute-on').addClass('d-none').removeClass('d-block');
        }
    }
});

let SweetAlert = new (function () {
    this.acceptQuery = function (id) {
        Swal.fire({
            title: '<p style="color: #ffffff;font-size: 23px;">Подтвердить заявку?</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Подтвердить!',
            cancelButtonText: 'Отмена',
            background: 'rgba(0,0,0,0.6)',
            iconColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $(".close").click();
                //Осуществляем рассылку заявки на ватсап
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/query/accept-query',
                    data: {
                        'queryId': id,
                    },
                    success: function (data) {
                        if ($('#query-list-wrapper').length > 0) {
                            setTimeout(function () {
                                let target = $('[data-id=' + id + ']').closest('tr');
                                if (target.hasClass('parent')) {
                                    target.next().remove();
                                }
                                target.remove();
                            }, 1000);
                        }

                        if (window.ReactNativeWebView === undefined) {
                            AlertNotification.alertSuccess('Успешно');
                        }
                    },
                    error: function (e) {
                        console.log('Error!', e.message);
                    }
                });
            }
        })
    };

    this.sendToWhatsApp = function (id) {
        Swal.fire({
            title: '<p style="color: #ffffff;font-size: 23px;">Инициировать рассылку?</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Отправить!',
            cancelButtonText: 'Отмена',
            background: 'rgba(0,0,0,0.6)',
            iconColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $(".close").click();
                //Осуществляем рассылку заявки на ватсап
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: window.location.origin + '/query/send-wa',
                    data: {
                        'queryId': id,
                    },
                    success: function (data) {
                        AlertNotification.alertSuccess(data.alertMessage);
                        if ($('#queries_table_wrapper').length > 0 && !parseInt(sentQueries)) {
                            QueryHandler.changeStatusInDom(2, id);
                            setTimeout(function () {
                                let target = $('.query-status[data-query-id=' + id + ']').closest('tr');
                                if (target.hasClass('parent')) {
                                    target.next().remove();
                                }
                                target.remove();
                            }, 1000);
                        }
                    },
                    error: function (e) {
                        console.log('Error!', e.message);
                    }
                });
            }
        })
    };
    this.deleteQueryFile = function (queryId, file, type) {
        Swal.fire({
            title: '<p style="color: #ffffff;font-size: 23px;">Удалить файл?</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Удалить!',
            cancelButtonText: 'Отмена',
            background: 'rgba(0,0,0,0.6)',
            iconColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                QueryHandler.deleteFile(queryId, file, type);
            }
        })
    };
});

let QueryHandler = new (function () {
    //Изменяет количество машин в форме заполнения заявки
    this.driverChangeEvent = function (target) {
        let machineCount = $(target).find('option:selected').length,
            machineType = $(target).data('machine-type');
        $(".machine-count[data-machine-type=" + machineType + "]").val(machineCount)
    };

    //Динамическое появление адресов
    this.dynamicAddressPopupEvents = function () {
        $(document).on('input', '#address', function () {
            var str = $(this).val();
            if (str != '') {
                //если блок с подсказкой скрыт - показываем его
                if ($('#address_options,#address_options_block').css('display') == 'none') {
                    $('#address_options,#address_options_block').show();
                }
                //очищаем содержимое блока с подсказкой
                $('#address_options').html('');

                ymaps.suggest(str).then(function (items) {
                    //заполняем содержимое блока с подсказкой
                    if (items.length > 0) {
                        $.each(items, function (key, value) {
                            $('#address_options').append('<div class="address_option_item">' + value.displayName + '</div>');
                        });
                    } else {
                        $('#address_options,#address_options_block').hide();
                    }
                });
            } else {
                //если пустая строка - скрываем блок с подсказкой
                $('#address_options,#address_options_block').hide();
            }
        });

        $(document).on('click', '.address_option_item', function () {
            $('#address').val($(this).text());
            $('#address_options, #address_options_block').hide();
        });

        $(document).on('input', '#base', function () {
            var str = $(this).val();
            if (str != '') {
                //если блок с подсказкой скрыт - показываем его
                if ($('#base_options,#base_options_block').css('display') == 'none') {
                    $('#base_options,#base_options_block').show();
                }
                //очищаем содержимое блока с подсказкой
                $('#base_options').html('');

                ymaps.suggest(str).then(function (items) {
                    //заполняем содержимое блока с подсказкой
                    if (items.length > 0) {
                        $.each(items, function (key, value) {
                            $('#base_options').append('<div class="base_option_item">' + value.displayName + '</div>');
                        });
                    } else {
                        $('#base_options,#base_options_block').hide();
                    }
                });
            } else {
                //если пустая строка - скрываем блок с подсказкой
                $('#base_options,#base_options_block').hide();
            }
        });

        $(document).on('click', '.base_option_item', function () {
            $('#base').val($(this).text());
            $('#base_options, #base_options_block').hide();
        });
    }

    this.queryStatusPicker = function (target) {
        $(target).parent().find('button[data-toggle="dropdown"]').css({
            "background": $(target).find('option:selected').css('background'),
        });
    };

    this.changeStatus = function (target, queryId) {
        let statusId = $('select.query-status-picker').val();
        if (statusId !== undefined && statusId !== null) {
            $.ajax({
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: window.location.origin + '/queries/status/update',
                data: {
                    'queryId': queryId,
                    'statusId': statusId
                },
                success: function (data) {
                    AlertNotification.alertSuccess(data.alertMessage);
                },
                error: function (e) {
                    console.log('Error!', e.message);
                }
            });
        }
    };

    this.changeStatusInDom = function (status, queryId) {
        $.ajax({
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: window.location.origin + '/get-status',
            data: {
                'id': status,
            },
            success: function (data) {
                let target = $('.query-status[data-query-id=' + queryId + ']');
                if (target.length > 0) {
                    target.css('background', data.color).text(data.title);
                }
            },
            error: function (e) {
                console.log('Error!', e.message);
            }
        });
    };

    this.deleteFile = function (queryId, file, type) {
        $.ajax({
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: window.location.origin + '/queries/file/delete',
            data: {
                'queryId': queryId,
                'file': file,
                'type': type,
            },
            success: function (data) {
                if (data.success) {
                    let target = $('[data-file-name="' + file + '"]');
                    let parentBlock = target.closest('.file-uploaded-wrapper');

                    target.remove();
                    if ($('[data-file-name]:visible').length === 0) {
                        parentBlock.remove();
                    }

                    AlertNotification.alertSuccess(data.alertMessage);
                }
            },
            error: function (e) {
                console.log('Error!', e.message);
            }
        });
    };

    this.queryMapModalInit = function (queryId, mapId) {
        $.ajax({
            type: "POST",
            dataType: "html",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: window.location.origin + '/queries/map/content',
            data: {
                'queryId': queryId,
                'mapId': mapId,
            },
            success: function (data) {
                $('#modal-query-map-wrapper .modal-body').html(data);
                $('#query-map-modal').modal({
                    show: true
                });
            },
            error: function (e) {
                AlertNotification.alertSuccess('Не удалось подгрузить историю заявки');
                console.log('Error!', e.message);
            }
        });
    };
});

let phoneHandler = new (function () {
    this.addMask = function (target = '.addQMask') {
        let mask = $(target);
        mask.mask("+7(999)999-99-99");
        mask.bind('paste', function (e) {
            e.preventDefault();
            let withoutSpaces = e.originalEvent.clipboardData.getData('Text').replace(/\D/g, '');
            mask.val(withoutSpaces).trigger('input');
        });
    };
});

let imageHandler = new (function () {
    this.changeImageOnInput = function (input, target) {
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(target).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            $(target).attr('src', '/assets/no_preview.png');
        }
    }
});

let formHandler = new (function () {
    this.queryFormStepper = function () {
        let verticalWizard = document.querySelector('.vertical-wizard-form');

        if (typeof verticalWizard !== undefined && verticalWizard !== null) {
            let queryWizardValidation = $(".needs-validation");

            queryWizardValidation.validate({
                rules: {
                    client_name: "required",
                    phone: {
                        required: true,
                        minlength: 16,
                    },
                    departure_date: "required",
                    price: "required",
                    weight: "required",
                    weight_from: "required",
                    address: "required",
                    cutters_count: "required",
                    loaders_count: "required",
                    oxygen_count: "required",
                    valdai_count: "required",
                    lomovoz_count: "required",
                    maz_count: "required",
                    opentop_count: "required",
                    kamaz_count: "required",
                    custom_latitude: "required",
                    custom_longitude: "required",
                },
                messages: {
                    client_name: "Введите Ф.И.O клиента",
                    phone: {
                        required: "Введите телефон клиента",
                        minlength: "Введите телефон полностью"
                    },
                    departure_date: "Необходимо выбрать дату и время выезда",
                    price: "Укажите цену металла",
                    weight: "Укажите вес металла",
                    weight_from: "Укажите вес металла",
                    address: "Укажите адрес выезда",
                    cutters_count: "Укажите количество резчиков",
                    loaders_count: "Укажите количество грузчиков",
                    oxygen_count: "Укажите количество кислорода",
                    valdai_count: "Укажите количество валдаев",
                    lomovoz_count: "Укажите количество ломовозов",
                    maz_count: "Укажите количество МАЗ-ов",
                    opentop_count: "Укажите количество опен-топ - ов",
                    kamaz_count: "Укажите количество Камаз-ов",
                    custom_latitude: "Укажите Широту",
                    custom_longitude: "Укажите Долготу",
                }
            });

            var verticalStepper = new Stepper(verticalWizard, {
                linear: false
            });

            let disableStepper = function () {
                if (!queryWizardValidation.valid()) {
                    $('.step-trigger').prop('disabled', true);
                } else {
                    $('.step-trigger').prop('disabled', false);
                }
            };
            $(document).on('form.needs-validation input', 'input', disableStepper);

            $(verticalWizard)
                .find('.btn-next')
                .on('click', function () {
                    if (typeof queryWizardValidation !== undefined && queryWizardValidation !== null) {
                        if (queryWizardValidation.valid()) {
                            verticalStepper.next();
                        }
                    } else {
                        verticalStepper.next();
                    }
                });
            $(verticalWizard)
                .find('.btn-prev')
                .on('click', function () {
                    verticalStepper.previous();
                });

            $(verticalWizard)
                .find('.btn-submit')
                .on('click', function () {
                    if (typeof queryWizardValidation !== undefined && queryWizardValidation !== null) {
                        queryWizardValidation.valid();
                    } else {
                        // alert('Submitted..!!');
                    }
                });
        }
    };

    this.MultiFilesInit = function () {
        let photoTarget = $("input.photo_upload_input");
        let videoTarget = $("input.video-upload-input");
        if (photoTarget.length > 0) {
            photoTarget.MultiFile({
                list: ".photo-upload-previews",
                maxsize: 1024 * 20,
            });
        }
        if (videoTarget.length > 0) {
            videoTarget.MultiFile({
                list: ".video-upload-previews",
                maxsize: 1024 * 500,
            });
            //Идиотский костыль для плагина MultiFile
            $(document).on('change', 'input.video-upload-input', function () {
                setTimeout(function () {
                    $('.video-upload-previews .MultiFile-preview').each(function () {
                        let target = $(this);
                        let src = target.attr('src');
                        let inner = target.html();
                        target.replaceWith('<video class="MultiFile-preview" src="' + src + '">' + inner + '</video>')
                    });
                }, 100);
            });
        }
    }
});

let GFHelper = new (function () {
    this.copyTextFromElement = function (element) {
        var tmp = $("<textarea>");
        $("body").append(tmp);
        tmp.val($(element).text()).select();
        document.execCommand("copy");
        tmp.remove();

        AlertNotification.alertSuccess('Скопировано');
    };

    this.copyToClipboard = function (text) {
        var textField = document.createElement('textarea');
        textField.innerText = text;
        document.body.appendChild(textField);
        textField.select();
        textField.focus();
        document.execCommand('copy');
        textField.remove();

        AlertNotification.alertSuccess('Скопировано');
    };

    this.isMobile = function () {
        let check = false;
        (function (a) {
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
        })(navigator.userAgent || navigator.vendor || window.opera);
        return check;
    };

    this.isTablet = function () {
        let standalone = window.navigator.standalone,
            userAgent = window.navigator.userAgent.toLowerCase(),
            safari = /safari/.test(userAgent),
            ios = /iphone|ipod|ipad/.test(userAgent),
            isTablet = false;

        if (ios) {
            if (!standalone && safari) {
                isTablet = true;
            }
        }

        if (!isTablet) {
            isTablet = /(iPad|iPhone|iPod|ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk|(puffin(?!.*(IP|AP|WP))))/.test(userAgent);
        }

        return isTablet;
    }

    this.submitForm = function (target, disable = "disabled") {
        $(target).prop("disabled", disable);
        $(target).closest('form').submit();
    }

    this.share = function (url, title = 'Ссылка на заявку M1-Logistics') {
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url,
            }).then(() => {

            }).catch(console.error);
        } else {
            GFHelper.copyToClipboard(url);
        }
    }
});

let FancyBoxHanler = new (function () {
    this.QueryModalFancyBoxInit = function () {
        $().fancybox({
            selector: '.modal.show .carousel-item a',
            hash: false,
            thumbs: {
                autoStart: false
            },
        });
    };
});

let PusherHandler = new (function () {
    let pusher = undefined;
    let channel = undefined;

    this.init = function () {
        PusherHandler.logToConsole(false);
        let pusher = new Pusher('36f1803c4b375570c839', {
            cluster: 'eu'
        });
        PusherHandler.pusher = pusher;
        PusherHandler.channel = pusher.subscribe('base-channel');
    };

    this.eventsInit = function () {
        if (UserHandler.isAdmin() || UserHandler.isLogist()) {
            PusherHandler.channel.bind('new-query-event', function (data) {
                if (window.ReactNativeWebView === undefined) {
                    AlertNotification.alertSuccess(data.alertMessage, data.alertTimeout);
                    AlertNotification.playSound(AlertNotification.notificationSoundPath);
                }

                //Update DataTable
                if (queryDataTable !== undefined) {
                   queryDataTable.updateDataTable();
                }
            });
        }

        // PusherHandler.channel.bind('query-accept', function (data) {
        //     if (window.ReactNativeWebView !== undefined) {
        //         const event = new Event('queryAccepted');
        //
        //         document.addEventListener('queryAccepted', function (e) {
        //             if (window.ReactNativeWebView !== undefined) {
        //                 window.ReactNativeWebView.postMessage(JSON.stringify({
        //                     'eventName': 'queryAccepted',
        //                     'message': 'Вам поступила новая заявка!',
        //                     'users': data.users,
        //                 }));
        //             }
        //         }, false);
        //
        //         document.dispatchEvent(event);
        //     }
        // });
    };

    this.logToConsole = function (on = true) {
        Pusher.logToConsole = on;
    }
});

let UserHandler = new (function () {
    this.AuthUser = undefined;
    this.AdminRoleId = 1;
    this.LogistRoleId = 2;
    this.ManagerRoleId = 3;

    this.init = function () {
        if ($('#auth-user-data').length > 0) {
            UserHandler.AuthUser = JSON.parse($('#auth-user-data').val());
        }
    };

    this.isAdmin = function () {
        return (UserHandler.AuthUser !== undefined && UserHandler.AuthUser.role_id === this.AdminRoleId);
    };

    this.isLogist = function () {
        return (UserHandler.AuthUser !== undefined && UserHandler.AuthUser.role_id === this.LogistRoleId);
    };

    this.isManager = function () {
        return (UserHandler.AuthUser !== undefined && UserHandler.AuthUser.role_id === this.ManagerRoleId);
    };
});

let FlatPickerHandler = new (function () {
    this.init = function () {
        let flatPicker = $('.flat-picker');

        if (flatPicker.length) {
            flatPicker.each(function () {
                $(this).flatpickr({
                    mode: "range",
                });
            });
        }
    };
});

let getCookie = function (name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

let setCookie = function (name, value, time) {
    var date = new Date();
    date.setTime(date.getTime() + time);
    let expires = "; expires=" + date.toUTCString();
    document.cookie = name + "=" + value + expires + "; path=/";
}

$(document).ready(function () {
    //Получаем данные авторизованного юзера
    UserHandler.init();

    //Костыль для DataTables (открытие списка столбцов при клике на колонку)
    $(document).on('click touch', 'table .dtr-control', function () {
        $(this).closest('tbody').find('.query_modal_view').appendTo('body');
    });

    //Инициация уведомления при открытии страниц
    if ($('#alertMessage').val()) {
        AlertNotification.alertSuccess($('#alertMessage').val())
    }

    //Иконка звука
    AlertNotification.muteSoundTriggerIconTrigger();

    //Динамическое появление адресов
    QueryHandler.dynamicAddressPopupEvents();

    //Маска на телефон
    phoneHandler.addMask();

    //Если есть форма то включаем Stepper с Валидацией
    formHandler.queryFormStepper();
    formHandler.MultiFilesInit();

    //Выделяем цифры при клике (Сделали для удобства)
    $(".vertical-wizard input[type=number]").focus(function () {
        $(this).select();
    });

    //Pusher
    PusherHandler.init();
    PusherHandler.eventsInit();

    //PullToRefresh
    const ptr = PullToRefresh.init({
        mainElement: '.content-wrapper',
        instructionsPullToRefresh: 'Потяните вниз, чтобы обновить',
        instructionsReleaseToRefresh: 'Отпустите, чтобы обновить',
        instructionsRefreshing: 'Обновляем',
        onRefresh() {
            window.location.reload();
        }
    });

    //PWA
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('https://www.m1-logistics.ru/serviceworker.js').then(function (registration) {
            // console.log('PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            console.log('PWA: ServiceWorker registration failed: ', err);
        });
    } else {
        console.log('ServiceWorker Not Found');
    }
});

//Включаем tooltips
$(function () {
    if (!GFHelper.isMobile() && !GFHelper.isTablet() && window.innerWidth >= 1100) {
        $('body').tooltip({
            selector: '[data-toggle-tooltip="tooltip"]',
            container: 'body'
        });
    }
})