$(function () {
    "use strict";
    console.log(route("user.userList"));
    $("#user-list-table").DataTable({
        serverSide: true,
        ajax: {
            url: route("user.userList"),
            method: "GET",
            dataType: "json",
            dataSrc: "",
        },
        columns: [
            {
                data: "",
            },
            {
                data: "name_surname",
            },
            {
                data: "wage_id",
            },
            {
                data: "birthday",
            },
            {
                data: "user_id",
            },
            {
                data: "",
            },
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, full, meta) {
                    return "<p>#</p>";
                },
            },
            {
                targets: 1,
                render: function (data, type, full, meta) {
                    if (data !== null) {
                        return `<p>${data}</p>`;
                    } else {
                        return "---";
                    }
                },
            },
            {
                targets: 2,
                render: function (data, type, full, meta) {
                    if (data !== null) {
                        return `<p>${data}</p>`;
                    } else {
                        return "---";
                    }
                },
            },
            {
                targets: 3,
                render: function (data, type, full, meta) {
                    if (data !== null) {
                        return `<p>${data}</p>`;
                    } else {
                        return "---";
                    }
                },
            },
            {
                targets: 4,
                render: function (data, type, full, meta) {
                    if (data !== null) {
                        return `<p>${data}</p>`;
                    } else {
                        return "---";
                    }
                },
            },
            {
                targets: 5,
                render: function (data, type, full, meta) {
                    return `<div class="btn-tooltip">
                                <a href="#" class="btn bg-transparent p-0">${feather.icons[
                                    "edit-2"
                                ].toSvg({
                                    class: "font-small-4 text-primary",
                                })}</a>
                            <button class="btn bg-transparent p-0" onclick="deleteHandler(this,${
                                full["user_id"]
                            })">${feather.icons["trash"].toSvg({
                        class: "font-small-4 text-danger",
                    })}</button>
                            </div>`;
                },
            },
        ],
        searching: false,
        info: false,
        paginate: false,
        language: {
            paginate: {
                // remove previous & next text from pagination
                previous: "&nbsp;",
                next: "&nbsp;",
            },
        },
    });
});

function deleteHandler(el, id) {
    Swal.fire({
        title: "Silmek istediğinize emin misiniz ?",
        text: "Bu işlem geri alınamaz !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Evet, sil !",
        cancelButtonText: "İptal et !",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-outline-secondary ms-1",
        },
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            let url = "{{ route('company.delete', ':id') }}";
            url = url.replace(":id", id);

            $.ajax({
                method: "DELETE",
                url: url,
                success: (res, textStatus, xhr) => {
                    if (xhr.status === 200) {
                        Swal.fire({
                            icon: "success",
                            title: "Başarılı!",
                            text: res.message,
                            customClass: {
                                confirmButton: "btn btn-success",
                            },
                        });

                        $(el).closest("tr").remove();
                    }
                },
                error: (err) => {
                    toastr["error"](err.responseJSON.message, "Başarılı!", {
                        closeButton: true,
                        tapToDismiss: true,
                        timeOut: 3000,
                        progressBar: true,
                    });
                },
            });
        }
    });
}
