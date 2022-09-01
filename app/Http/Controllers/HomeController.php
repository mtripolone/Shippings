<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ShippingResource;
use App\Repositories\ShippingRepository;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    protected ShippingRepository $repository;

    public function __construct(ShippingRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('auth');
    }

    public function index(): View
    {
        $title     = 'Shippings';
        $shippings = ShippingResource::collection($this->repository->getAllShippings());
        return view('pages.shipping', ['title' => $title, 'shippings' => $shippings]);
    }
}
