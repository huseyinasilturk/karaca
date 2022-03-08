@extends('layouts/contentLayoutMaster')

@section('title', 'App Calender')

@section('vendor-style')
  <!-- Vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/fullcalendar.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/css/plugins/sweetalert2.min.css') }}" />

<style>
    #search-input {
        background: transparent;
        /* border: 0; */
        color: #212121;
        font-size: .8rem;
        line-height: 2;
        padding: 8px;
        border: 1px solid #bbb;
        outline: none;
        border-radius: 4px;
    }

</style>
@endsection

@section('content')
<div class="row">

    <div class="col-12 mb-4">
        <div class="d-flex align-items-center">
            <h4>@lang("Nesneler")</h4>
            <input class=" ml-3 w-25" type="text" id="search-input" oninput="searchObject(this)"
                placeholder="@lang('Nesne Ara')" title="@lang('Nese Arama Kutusu')">
        </div>

    </div>
    @foreach ($objectivesTypes as $key => $objective)
        <div class="col-12 col-lg-6 col-xl-4 objective-div" search-data="{{ $objective['name'] }}">
            <div class="card mb-5">
                <div class="card-body p-3">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                              <a
                                class="accordion-button"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#{{ $key }}"
                                aria-expanded="true"
                                aria-controls="{{ $key }}"
                                data-title="{{ $objective['name'] }}"
                              >
                              {{$objective['name']}}
                              </a>
                            </h2>
                            <div
                         data-parent="#{{ $key }}"
                              id="{{ $key }}"
                              class="accordion-collapse collapse show"
                            >
                              <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                @foreach ($objective['inputs'] as $input)
                                                    <th scope="col">{{ $input }}</th>
                                                @endforeach
                                                <th scope="col">@lang("İşlemler")</th>
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
                                                                data-toggle="modal" data-form="{{ $key }}"
                                                                data-target="#objective-modal">
                                                                <i
                                                                    class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                                            <a class="text-danger m2 delete-objective"
                                                                onclick="deleteObjective(this)"
                                                                data-id={{ $item['id'] }} href="#"><i
                                                                    class="nav-icon i-Close-Window font-weight-bold"></i></a>
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
                      <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                              <a
                                class="accordion-button"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#{{ $key }}-add"
                                aria-expanded="true"
                                aria-controls="{{ $key }}-add"
                                data-title="{{ $objective['name'] }}"
                              >
                              {{$objective['name']}}
                              </a>
                            </h2>
                            <div
                         data-parent="#{{ $key }}-add"
                              id="{{ $key }}-add"
                              class="accordion-collapse collapse  show"
                            >
                              <div class="accordion-body">
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0"><a
                                            class="text-default collapsed" data-toggle="collapse"
                                            href="#{{ $key }}-add"
                                            aria-expanded="false">{{ $objective['name'] }}
                                            Ekle</a>
                                    </h6>
                                </div>
                                <div class="collapse" id="{{ $key }}-add"
                                    data-parent="#{{ $key }}" style="">
                                    <div class="card-body">
                                        <form id="{{ $key }}-form">
                                            <input type="hidden" name="name" value="{{ $key }}">
                                            <div class="d-flex flex-column">
                                                @foreach ($objective['inputs'] as $inputKey => $input)
                                                    @if (Str::startsWith($inputKey, 'number'))
                                                        <div class="form-group">
                                                            <input class="form-control objective-input"
                                                                name="{{ $inputKey }}" type="number"
                                                                placeholder="@lang($input)">
                                                        </div>
                                                    @elseif (Str::startsWith($inputKey, 'text'))
                                                        <div class="form-group">
                                                            <input class="form-control objective-input"
                                                                name="{{ $inputKey }}" type="text"
                                                                placeholder="@lang($input)">
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <button type="button" class="btn btn-primary pd-x-20"
                                                    id="{{ $key }}-add-button"
                                                    onclick="addObjective(this)">@lang("Ekle")</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>


                    <div class="accordion" >
                        <div class="card">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a class="text-default collapsed objective-title"
                                        data-title="{{ $objective['name'] }}" data-toggle="collapse"
                                        href="#{{ $key }}" aria-expanded="false"</a>
                                </h6>
                            </div>
                            <div class="collapse" id="{{ $key }}" data-parent="#{{ $key }}"
                                style="">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0"><a
                                        class="text-default collapsed" data-toggle="collapse"
                                        href="#{{ $key }}-add"
                                        aria-expanded="false">{{ $objective['name'] }}
                                        Ekle</a>
                                </h6>
                            </div>
                            <div class="collapse" id="{{ $key }}-add"
                                data-parent="#{{ $key }}" style="">
                                <div class="card-body">
                                    <form id="{{ $key }}-form">
                                        <input type="hidden" name="name" value="{{ $key }}">
                                        <div class="d-flex flex-column">
                                            @foreach ($objective['inputs'] as $inputKey => $input)
                                                @if (Str::startsWith($inputKey, 'number'))
                                                    <div class="form-group">
                                                        <input class="form-control objective-input"
                                                            name="{{ $inputKey }}" type="number"
                                                            placeholder="@lang($input)">
                                                    </div>
                                                @elseif (Str::startsWith($inputKey, 'text'))
                                                    <div class="form-group">
                                                        <input class="form-control objective-input"
                                                            name="{{ $inputKey }}" type="text"
                                                            placeholder="@lang($input)">
                                                    </div>
                                                @endif
                                            @endforeach
                                            <button type="button" class="btn btn-primary pd-x-20"
                                                id="{{ $key }}-add-button"
                                                onclick="addObjective(this)">@lang("Ekle")</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                            onclick="modalUpdateHandler()">@lang("Güncelle")</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}"></script>
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
            toastr.error("@lang('Boş değer giremezsiniz.')")
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

                        newRow.append($(`
                    <td>
                        <a class="text-success mr-2 edit-objective" onclick="editObjective(this)" href="#"
                            data-toggle="modal" data-form="${data['name']}"
                            data-target="#objective-modal"><i
                                class="nav-icon i-Pen-2 font-weight-bold"></i></a><a
                            class="text-danger m2 delete-objective" onclick="deleteObjective(this)" href="#"><i
                                class="nav-icon i-Close-Window font-weight-bold"></i></a>
                    </td>
                    `));

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
        swal({
            title: "@lang('Nesneyi Silmek İstediğinize Emin Misiniz')?",
            text: "@lang('Silinen nesne geri alınamaz')!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0CC27E",
            cancelButtonColor: "#FF586B",
            confirmButtonText: "@lang('Evet, sil')!",
            cancelButtonText: "@lang('Hayır, iptal et')!",
            confirmButtonClass: "btn btn-success mr-5",
            cancelButtonClass: "btn btn-danger",
            buttonsStyling: false
        }).then(function() {
            // Tıklanan butonun id'sini al
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
                        <a class="text-success mr-2 edit-objective" onclick="editObjective(this)" href="#"
                            data-toggle="modal" data-form="${formData['name']}"
                            data-target="#objective-modal"><i
                                class="nav-icon i-Pen-2 font-weight-bold"></i></a><a
                            class="text-danger m2 delete-objective" deleteObjective(this) href="#"><i
                                class="nav-icon i-Close-Window font-weight-bold"></i></a>
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


