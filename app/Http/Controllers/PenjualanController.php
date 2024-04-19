<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use App\Models\Pelanggans;
use App\Models\Penjualans;
use App\Models\Produks;
use App\Models\LogStock;
use Illuminate\Support\Facades\Auth;
class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $produk =[];
        
        $code =$request->code;
        $quantity = $request->quantity;

        foreach ($code as $index => $code){
            $produk[]=[
                "code" => $code,
                "quantity" => $quantity[$index]
            ];
        }
        
        $codeToSearch = array_column($produk, 'code');
        $items = Produks::whereIn('code', $codeToSearch)->get();
        $errorMessages = [];

        foreach ($produk as $product){
            $found = false;
            foreach ($items as $item){
                if ($product["code"] == $item->code){
                    $found = true;
                    if ($product["quantity"] > $item->stock){
                        $errorMessages[] = "Stok Produk  ". $item->name_produk. "dengan kode" . $product["code"]. "Tidak Mencukupi";
                    }
                    break;
                }
            }
            if (!$found){
                $errorMessages[] = $product["code"];
            }
        }

        if (!empty($errorMessages)){
            return back()->with("fail", $errorMessages);

        }

        $name = $request->name;
        $phone = $request->no_phone;
        $address = $request->address;

        session([
            "produk" => $produk,
            "pelanggan" => [
                "name" => $name,
                "no_phone" => $phone,
                "address" => $address,
            ]
        ]);

        return view("Penjualan.index", compact(
            "name",
            "phone",
            "address",
            "produk",
            "item"
        ));  

    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        $produk = session("produk");
        $codeToSearch = array_column($produk, 'code');
        $item =Produks::whereIn('code', $codeToSearch)->get();
        $total = 0;
        foreach ($item as $a){
            foreach ($produk as $product){
                if ($product["code"] == $a->code){
                    $price = $product["quantity"] * $a->price;
                    $total += $price;
                }
            }
        }

        $customer = session("pelanggan");
        if ($customer["address"] == null){
            $customer =  Pelanggans::create([
                "name_customer" => $customer["name_customer"],
                "no_phone" => $customer["no_phone"],
            ]);
        }

        $customer = Pelanggans::create([
            "name_customer" => $customer["name_customer"],
            "no_phone" => $customer["no_phone"],
            "address" => $customer["address"]
        ]);

        $penjualan = Penjualans::create([
            "pelanggan_id" => $customer->id,
            "date_sale" => now(),
            "total" => $total,
        ]);

        foreach ($item as $a){
            foreach ($produk as $p){
                if ($p["code"] == $a->code){
                    DetailPenjualan::create([
                        'penjualan_id' =>$penjualan->id,
                        'produk_id' => $item->id,
                        'produk_total' => $produk["quantity"],
                        'subtotal' => $a->$price * $p["quantity"]
                    ]);

                    LogStock::create([
                        'user_id' => Auth::user()->id,
                        'produk_id' => $a->id,
                        'produk_total' => $p["quantity"],
                        'status' => "out"
                    ]);
                }
            }
        }
        return redirect()->route("penjualan.checkout")->with("success", "Transaksi berhasil!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
