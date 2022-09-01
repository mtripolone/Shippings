<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ShippingResource;
use App\Repositories\ShippingRepository;
use App\Services\Import;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    protected $repository;

    public function __construct(ShippingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): View
    {
        $title     = 'Shippings';
        $shippings = ShippingResource::collection($this->repository->getAllShippings());
        return view('pages.shipping', ['title' => $title, 'shippings' => $shippings]);
    }

    public function store(Request $request)
    {
        $csvFile = $request->file('shipping_file');

        if ($csvFile->getClientMimeType() != "text/csv") {
            return response(['type' => 500, 'message' => 'Please enter a value type'], 500);
        }

        $import = new Import();
        return $import->csvFile(
            $csvFile,
            ['from_postcode', 'to_postcode', 'from_weight', 'to_weight', 'cost'],
            $this->repository
        );
    }
}
