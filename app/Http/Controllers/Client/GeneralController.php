<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CapacityService;
use App\Services\CategoryService;
use App\Services\ColorService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GeneralController extends Controller
{
    protected $productService;
    protected $colorService;
    protected $capacityService;

    protected $categoryService;
    public function __construct(
        ProductService $productService,
        ColorService $colorService,
        CapacityService $capacityService,
        CategoryService $categoryService
    ) {
        $this->productService = $productService;
        $this->colorService = $colorService;
        $this->capacityService = $capacityService;
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $products = $this->productService->getFeaturedProduct(4);
        $product_featured = Product::query()->where('featured', 1)->latest('id')->limit(6)->get();
        // dd($products);
        return view('client.index', compact('products', 'product_featured'));
        // return view('client.index');
    }
    public function shop()
    {

        $products = $this->productService->getProduct([]);

        $categories = $this->categoryService->pluckCategory('name', 'id');

        return view('client.shop', compact('products', 'categories'));
    }

    public function detail(string $id)
    {

        $dataDetails    = $this->productService->findIDRelationProduct($id, ['category', 'galleries', 'product_variant']);

        $colors         = $this->colorService->pluckColor('name', 'id');
        $Capacities     = $this->capacityService->pluckCapacity('name', 'id');

        $variants       = $this->productService->productvariantFindbyProduct_id($id, ['capacity', 'color']);

        // dd($variants->toArray());
        return view('client.detail', compact(
            'dataDetails',
            'variants',
            'colors',
            'Capacities'
        ));
    }
    public function search(Request $request)
    {
        $key = $request->keysearch;

        $products = Product::query()
            ->whereAny(['name'], 'LIKE', "%$key%")
            ->get();
        return view('client.search', compact('products'));
    }
    public function searchfilter(Request $request)
    {
        $categories = $this->categoryService->pluckCategory('name', 'id');

        $filter_price = explode('-', $request->filter_price);
        $products = Product::query()
            ->whereAny(['category_id'], 'LIKE', "%$request->category_id%")
            ->whereBetween('price_regular', $filter_price)->paginate(8);

        return view('client.shop', compact('products', 'categories'));
    }


















    public function about()
    {
        return view('client.about');
    }
    public function blog()
    {
        return view('client.blog');
    }

    public function checkout()
    {
        return view('client.checkout');
    }
    public function contact()
    {
        return view('client.contact');
    }
    public function services()
    {
        return view('client.services');
    }
}
