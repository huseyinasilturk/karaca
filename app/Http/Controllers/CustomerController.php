<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\Objective;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Müşteriler"], ['name' => "Listele"]
        ];
        $customers = Customer::with("type")->get();
        $customerTypes = Objective::where("name", "customerType")->get();

        return view("live.customer.index", compact("breadcrumbs", "customers", "customerTypes"));
    }

    public function add()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Müşteriler"], ['name' => "Ekle"]
        ];
        $customerTypes = Objective::where("name", "customerType")->get();
        return view("live.customer.add", compact("breadcrumbs", "customerTypes"));
    }

    public function store(CustomerRequest $request)
    {
        $createCustomer = Customer::create($request->validated());

        if (!$createCustomer) {
            return response()->json(["message" => "Müşteri oluşturulamadı"], 404);
        }

        return response()->json(["message" => "Müşteri başarıyla oluşturuldu"], 201);
    }

    public function customers()
    {
        $customers = Customer::with("type")->get();

        return response()->json($customers, 200);
    }

    public function delete($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(["message" => "Müşteri bulunamadı"], 404);
        }

        $deleteCustomer = $customer->delete();

        if (!$deleteCustomer) {
            return response()->json(["message" => "Müşteri silinirken hata oluştu"], 404);
        }
        return response()->json(["message" => "Müşteri başarıyla silindi"], 200);
    }

    public function edit($id)
    {

        $customer = Customer::find($id);

        $customerTypes = Objective::where("name", "customerType")->get();
        if (!$customer) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Müşteriler"], ['name' => "Müşteri Ekle"]
            ];
            return view("live.customer.add", compact("breadcrumbs", "customerTypes"));
        }

        $breadcrumbs = [
            ['link' => "/", 'name' => "Anasayfa"], ['link' => "javascript:void(0)", 'name' => "Müşteriler"], ['name' => "Müşteri Güncelle"]
        ];

        $customer = $customer->load("type");
        return view("live.customer.edit", compact("breadcrumbs", "customer", "customerTypes"));
    }

    public function update(CustomerRequest $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(["message" => "Müşteri bulunamadı"], 404);
        }

        $updateCustomer = $customer->update($request->validated());

        if (!$updateCustomer) {
            return response()->json(["message" => "Müşteri güncellenirken hata oluştu"], 404);
        }

        return response()->json(["message" => "Müşteri başarıyla güncellendi"], 200);
    }

    public function filter(Request $request)
    {
        $customers = Customer::query();

        if ($request->filled("customer_id")) {
            if ($request->customer_id != "-1") {
                $customers = $customers->where("id", $request->customer_id);
            }
        }

        if ($request->filled("customer_type_id")) {
            if ($request->customer_type_id != "-1") {
                $customers = $customers->where("customer_type_id", $request->customer_type_id);
            }
        }

        $customers = $customers->get()->load("type");

        return response()->json($customers, 200);
    }
}
