<div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reminderModalLabel">Hatırlatıcılar</h5>
                <button type="button" class="close" onClick='$("#reminderModal").modal("hide")'
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reminder-form">

                </form>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN: Vendor JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset(mix('vendors/js/ui/jquery.sticky.js')) }}"></script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>

<!-- custome scripts file for user -->
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>

@if ($configData['blankPage'] === false)
    <script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js"
integrity="sha512-eiqtDDb4GUVCSqOSOTz/s/eiU4B31GrdSb17aPAA4Lv/Cjc8o+hnDvuNkgXhSI5yHuDvYkuojMaQmrB5JB31XQ=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@yield('page-script')
<script>
    $(function() {
        let ip_address = '127.0.0.1';
        let socket_port = '9699';
        let socket = io(ip_address + ':' + socket_port);
        let handleLocalStorage = $("<div>" + (localStorage.getItem("notification") != null ? localStorage
            .getItem("notification") : "") + "</div>");
        $(".notifications_navbar").html(handleLocalStorage.html());

        socket.on('getStockServer', (message, id, companyId) => {

            const companyIdServer =
                {{ !empty(auth()->user()->company_id) ? auth()->user()->company_id : -1 }};

            if (companyId == companyIdServer) {

                let handleLocalStorage = $("<div>" + (localStorage.getItem("notification") != null ?
                    localStorage.getItem("notification") : "") + "</div>");

                let handleLocalStorageLength = handleLocalStorage.find("a").length;
                if (handleLocalStorageLength > 4) {
                    handleLocalStorage.find("a").eq(0).remove();
                }

                let stockNotification = $(`
                    <a class="d-flex" href="javascript:void(0)">
                        <div class="list-item d-flex align-items-start">
                            <div class="me-1">
                                <div class="avatar bg-light-warning">
                                    <div class="avatar-content"><i class="avatar-icon"
                                            data-feather="alert-triangle"></i></div>
                                </div>
                            </div>
                            <div class="list-item-body flex-grow-1">
                                <p class="media-heading"><span class="fw-bolder">Stok Uyarısı</span>
                                </p><small class="notification-text"> ${message}</small>
                            </div>
                        </div>
                    </a>`);
                handleLocalStorage.append(stockNotification);
                localStorage.setItem("notification", handleLocalStorage.html());


                $(".notifications_navbar").html(handleLocalStorage.html());

                notificationHam("Stok Uyarısı", message, "error", 2000)
                id.map((val) => {
                    $("span[pro_id='" + val["id"] + "']").html(val["adet"])
                })
            }

        });

        let count = 0;

        setInterval(() => {
            count++;
            socket.emit('reminderServerSend', "sadsad" + count);
            axios.get("reminder/notifications").then(res => {
                console.log(res);
                let handleLocalStorage = $("<div>" + (localStorage.getItem("notification") !=
                    null ?
                    localStorage.getItem("notification") : "") + "</div>");

                let handleLocalStorageLength = handleLocalStorage.find("a").length;
                if (handleLocalStorageLength > 4) {
                    handleLocalStorage.find("a").eq(0).remove();
                }

                let message = ""

                res.data.map(val => {
                    message += val.title + "<br>"
                })

                let stockNotification = $(`
                    <a class="d-flex" href="javascript:void(0)" onclick="modalShowReminder()" >
                        <div class="list-item d-flex align-items-start">
                            <div class="me-1">
                                <div class="avatar bg-light-primary">
                                    <div class="avatar-content"><i class="avatar-icon"
                                            data-feather="alert-triangle"></i></div>
                                </div>
                            </div>
                            <div class="list-item-body flex-grow-1">
                                <p class="media-heading"><span class="fw-bolder">Hatırlatıcı Uyarısı</span>
                                </p><small class="notification-text"> ${message}</small>
                            </div>
                        </div>
                    </a>`);
                handleLocalStorage.append(stockNotification);
                localStorage.setItem("notification", handleLocalStorage.html());

                $(".notifications_navbar").html(handleLocalStorage.html());

                notificationHam("Hatırlatıcı Uyarısı", message, "error", 2000);

                id.map((val) => {
                    $("span[pro_id='" + val["id"] + "']").html(val["adet"])
                })
            });
        }, 1000 * 60 * 10);

        socket.on('reminderServerListen', (message) => {
            console.log(message);
        });

    });

    function modalShowReminder(test) {
        axios.get("reminder/notifications").then(res => {
            console.log("res", res);
            $('#reminder-form p').remove();
            if (res.data.length === 0) {
                $("#reminder-form").append("<p>Aktif hatırlatıcı bulunmamakta</p>")
            } else {
                res.data.map((val) => {
                    const box = $(`<div class="d-flex justify-content-between align-items-center pt-1 reminder-item">
                                    <span>${val.title}</span>
                                    <div class="d-flex flex-column">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" onchange="statusHandler(this,${val.id})" checked="true" class="form-check-input">
                                        </div>
                                    </div>
                                </div><hr/>`)
                    $("#reminder-form").append(box)
                })
            }

            $("#reminderModal").modal("show");
        })
    }

    function statusHandler(el, id) {
        axios.get("reminder/change-status/" + id).then(res => res.status === 200 && $(el).closest(".reminder-item")
            .remove())
    }
</script>



<!-- END: Page JS-->
