<div class="card">
    <div  class="  card-header d-flex justify-content-between   align-items-sm-center align-items-start  flex-sm-row flex-column ">
        <div class="header-left">
            <h4 class="card-title">Gider Raporu</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
             <div class="row ps-2 pe-2">
                <label for="colFormLabel" class="col-sm-3 col-form-label">Gider Tipi</label>
                <div class="col-sm-9">
                    <select class="form-select" id="expenseTypeSelect" onchange="expenseTypeChange(this)" >
                        <option value="-1" selected="">Seçiniz</option>
                        @forelse ($Objective["expenseType"]->keyBy("id") as $key => $val )
                            <option value="{{$key}}">{{$val->text1}}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row ps-2 pe-2">
                <label for="colFormLabel" class="col-sm-3 col-form-label">Gider Yılı</label>
                <div class="col-sm-9">
                    <input type="number" id="year" class="form-control" onkeyup="expenseYear(this)" min="1900" max="2099" step="1"  value="{{ now()->year }}" />
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <canvas class="giderTablo chartjs"  data-height="400"></canvas>
    </div>
</div>
<canvas class="giderTabloClone chartjs"  data-height="400"></canvas>
