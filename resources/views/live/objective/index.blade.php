@extends('layouts/contentLayoutMaster')

@section('title', 'Nesne')

@section('vendor-style')
    <!-- Vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/fullcalendar.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('page-style')

@endsection

@section('content')
    <div class="row">
        <div class="col-12 mb-2">
            <div>
                <input class="form-control ml-3 w-25" type="text" id="search-input" oninput="searchObject(this)"
                    placeholder="Nesne Ara" title="Nesne Arama Kutusu">
            </div>
        </div>
        @foreach ($objectivesTypes as $key => $objective)
            <div class="col-12 col-lg-6 accordion col-xl-4 objective-div" search-data="{{ $objective['name'] }}">
                <div class=" mt-2">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <a class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#{{ $key }}" aria-expanded="true"
                                aria-controls="{{ $key }}" data-title="{{ $objective['name'] }}">
                                {{ $objective['name'] }}
                            </a>
                        </h2>
                        <div data-parent="#{{ $key }}" id="{{ $key }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                @foreach ($objective['inputs'] as $input)
                                                    <th scope="col">{{ $input }}</th>
                                                @endforeach
                                                <th scope="col">İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($objectives[$key]))
                                                @foreach ($objectives[$key] as $item)
                                                    <tr data-id="{{ $item['id'] }}">
                                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                                        @foreach ($objective['inputs'] as $inputKey => $input)
                                                            <td>{{ $item[$inputKey] }}</th>
                                                        @endforeach
                                                        <td>
                                                            <a class="text-success mr-2 edit-objective"
                                                                onclick="editObjective(this)" href="#"
                                                                data-bs-toggle="modal" data-form="{{ $key }}"
                                                                data-bs-target="#objective-modal">
                                                                <i class="fa-solid fa-pen"></i></a>
                                                            <a class="text-danger m2 delete-objective"
                                                                onclick="deleteObjective(this)" data-id={{ $item['id'] }}
                                                                href="#"><i class="fa-solid fa-trash-can"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="  ">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <a class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#{{ $key }}-add" aria-expanded="true"
                                aria-controls="{{ $key }}-add" data-title="{{ $objective['name'] }}">
                                {{ $objective['name'] }}-Ekle
                            </a>
                        </h2>
                        <div data-parent="#{{ $key }}-add" id="{{ $key }}-add"
                            class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <form id="{{ $key }}-form">
                                    <input type="hidden" name="name" value="{{ $key }}">
                                    <div class="d-flex flex-column">
                                        @foreach ($objective['inputs'] as $inputKey => $input)
                                            @if (Str::startsWith($inputKey, 'number'))
                                                <div class="form-group">
                                                    <input class="form-control objective-input" name="{{ $inputKey }}"
                                                        type="number" placeholder="{{ $input }}">
                                                </div>
                                            @elseif (Str::startsWith($inputKey, 'text'))
                                                <div class="form-group">
                                                    <input class="form-control objective-input" name="{{ $inputKey }}"
                                                        type="text" placeholder="{{ $input }}">
                                                </div>
                                            @endif
                                        @endforeach
                                        <button type="button" class="btn btn-primary mt-1 pd-x-20"
                                            id="{{ $key }}-add-button" onclick="addObjective(this)">Ekle</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="objective-modal" tabindex="-1" role="dialog" aria-labelledby="objective-modal-label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="objective-modal-label"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal-form">
                        <div class="d-flex flex-column">
                            <div class="form-group" id="modal-form-body">
                                <input class="form-control" type="text" id="edit-objective-input" name="edit-name"
                                    placeholder="Kalite Adı">
                            </div>
                            <button type="button" class="btn btn-primary pd-x-20"
                                onclick="modalUpdateHandler()">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('page-script')

    <script>
        // Nesne search fonksiyonu
        function searchObject(e) {
            $(".objective-div").each((idx, el) => {
                const objectiveName = $(el).attr("search-data").toLowerCase();

                if (!objectiveName.includes($(e).val().toLowerCase())) {
                    $(el).addClass("d-none");
                } else {
                    $(el).removeClass("d-none");
                }
            })
        }

        // Post request gönderiyor ve dönen değeri forma ekliyor
        function addObjective(el) {
            const obj = formArrToObj($(el).closest("form").serializeArray());
            delete obj.name;
            const emptyForm = Object.values(obj).every(x => x === null || x === "");

            if (emptyForm) {
                toastr.error("Boş değer giremezsiniz.")
            } else {

                // Eğer ekleme tıklandığında accordion açık değilse açıyor
                const isAccordionOpen = $(el).closest(".accordion").find(".card").eq(0).children(".collapse").hasClass(
                    "show");
                if (isAccordionOpen === false) {
                    $(el).closest(".accordion").find(".card").eq(0).children(".collapse").addClass("show");
                }

                // Tıklanan elementin formunu objeye çevir
                let formData = $(el).closest("form").serializeArray();
                formData = formArrToObj(formData);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('objective.store') }}",
                    method: "POST",
                    data: formData,
                    beforeSend: function() {
                        $(el).attr('disabled', true);
                    },
                    success: (res) => {


                        if (res.status === 201) {
                            const data = {
                                ...res.data
                            };

                            const tableBody = $(el).closest(".accordion").find(".table-responsive").find(
                                "tbody");

                            let rowCount = $(tableBody).children("tr").length + 1;

                            const newRow = $(`<tr data-id="${res.id}"></tr>`);
                            newRow.append($(`<th>${rowCount}</th>`));

                            Object.keys(data).map((key, idx) => {
                                if (key !== "name") {
                                    const newTd = $(`<td>${data[key]}</td>`);
                                    newRow.append(newTd);
                                }
                            });



                            newRow.append($(` <td>
                                <a class="text-success mr-2 edit-objective"
                                onclick="editObjective(this)" href="#" data-bs-toggle="modal"
                                data-form="${data['name']}"
                                data-bs-target="#objective-modal">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a class="text-danger m2 delete-objective"
                                    onclick="deleteObjective(this)" data-id="${data['id']}"
                                    href="#"><i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>`));

                            tableBody.append(newRow);
                            toastr.success(res.message);

                            $(el).closest("form").find("input").each((key, val) => {
                                if ($(val).attr("type") !== "hidden") {
                                    $(val).val("");
                                }
                            })
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: (err) => {
                        const errors = err.responseJSON.errors;

                        Object.keys(errors).forEach((key, err) => {
                            errors[key].map(message => {
                                toastr.error(message);
                            });
                        });
                    },
                    complete: function() {
                        $(el).attr('disabled', false);
                    },
                });
            }

        }

        // Array olan FormData'yı objeye çevirir
        function formArrToObj(arr) {
            const obj = {};

            arr.forEach((val) => {
                obj[val.name] = val.value
            });

            return obj;
        }

        // Güncelleme butonunda modal aç
        function editObjective(e) {
            // Tıklanan butonun id'sini al
            const id = $(e).closest("tr").attr("data-id");

            // Açılan modalın başlığını değiştir
            const modalTitle = $(e).closest(".card").find(".objective-title").attr("data-title");
            $(".modal-title").html(modalTitle);

            // Tıklanan butonun formunun inputlarını, modalın içine yerleştir
            const formId = $(e).closest("a").attr("data-form") + "-form";
            $("#modal-form-body").empty();
            const form = $(`#${formId} input`).each((idx, el) => {
                $("#modal-form-body").append($(el).clone());
            });
            const idInput = $(`<input type="hidden" name="id" value="${id}" />`);
            $("#modal-form-body").append(idInput);
        }

        // Silme butonuna tıklanınca sil ...
        function deleteObjective(e) {
            Swal.fire({
                title: "Nesneyi Silmek İstediğinize Emin Misiniz?",
                text: "Silinen nesne geri alınamaz!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#0CC27E",
                cancelButtonColor: "#FF586B",
                confirmButtonText: "Evet, sil!",
                cancelButtonText: "Hayır, iptal et!",
                confirmButtonClass: "btn btn-success mr-5",
                cancelButtonClass: "btn btn-danger",
                buttonsStyling: false
            }).then(function(result) {
                // Tıklanan butonun id'sini al
                if (result.isConfirmed) {
                    const id = $(e).closest("tr").attr("data-id");

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('objective.delete') }}",
                        method: "DELETE",
                        data: {
                            id: id
                        },
                        success: res => {
                            if (res.status === 200) {
                                $(e).closest(`tr[data-id="${id}"]`).remove();
                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }
                        }
                    });
                }
            }, function(dismiss) {});

        }

        // Modal updatelemesi
        function modalUpdateHandler() {
            const formData = formArrToObj($("#modal-form").serializeArray());

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });


            $.ajax({
                url: "{{ route('objective.update') }}",
                method: "PUT",
                data: formData,
                success: (res) => {
                    if (res.status === 200) {

                        const data = {
                            ...res.data
                        }

                        // Eski tr'yi bulmak için değerler
                        const parentId = $("#modal-form").find('input[name="name"]').val();
                        const rowId = $("#modal-form").find('input[name="id"]').val();

                        // Silinecek tr'nin tablodaki sayısı
                        const count = parseInt($(`#${parentId}`).find("tbody").find(
                            `tr[data-id="${rowId}"]`).find("th").text());


                        // Yeni tr oluştur
                        const newRow = $(`<tr data-id="${rowId}"></tr>`);

                        newRow.append($(`<th>${count}</th>`));

                        Object.keys(formData).map((key, idx) => {
                            if (key !== "name" && key !== "id") {
                                const newTd = $(`<td>${formData[key]}</td>`);
                                newRow.append(newTd);
                            }
                        });

                        newRow.append($(`
                                <td>
                                    <a class="text-success mr-2 edit-objective"
                                    onclick="editObjective(this)" href="#" data-bs-toggle="modal"
                                    data-form="${data['name']}"
                                    data-bs-target="#objective-modal">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a class="text-danger m2 delete-objective"
                                        onclick="deleteObjective(this)" data-id="${data['id']}"
                                        href="#"><i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            `));

                        // Eski tr'yi, yenisi ile değiştir
                        $(`#${parentId}`).find(`tr[data-id="${rowId}"]`).replaceWith(newRow);

                        toastr.success(res.message);

                        $(".modal").modal("hide");

                    } else {
                        toastr.error(res.message);
                    }
                },
                error: (err) => {
                    const errors = err.responseJSON.errors;

                    Object.keys(errors).forEach((key, err) => {
                        errors[key].map(message => {
                            toastr.error(message);
                        });
                    });
                }
            })
        }

        // Inputa enterlanırsa direk ekleme fonksiyonu çalıştır
        $(".objective-input").on("keypress", e => {
            if (e.which === 13) {
                addObjective($(e.target));
                $(e.target).val("");
                e.preventDefault();
            }
        })
    </script>
@endsection
