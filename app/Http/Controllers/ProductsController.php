<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\Cursor;

class ProductsController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $nextCursor = $request->cursor;   
            $products = Product::whereBetween('price',[30,7000])->orderBy('id')->orderBy('price')->cursorPaginate(18,['*'],'cursor',Cursor::fromEncoded($nextCursor));
            $result = [
                'html'=>view('products.ajax.grid', ['products'=>$products])->render(),
                'next_url'=>$products->nextCursor()->encode()
            ];
            return $result;
        }
        $products = Product::whereBetween('price',[30,7000])->orderBy('id')->orderBy('price')->cursorPaginate(18,['*'],'cursor',NULL);
        return view('products.grid', ['products'=>$products, 'next_url'=>$products->nextCursor()->encode()]);
    }
}
