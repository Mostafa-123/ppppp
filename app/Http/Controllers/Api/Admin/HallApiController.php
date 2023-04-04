<?php

namespace App\Http\Api\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHallRequest;
use App\Http\Requests\UpdateHallRequest;
use App\Http\Resources\Admin\HallResource;
use app\Models\Hall;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HallsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Hall_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HallResource(Hall::with(['hall'])->get());
    }

    public function store(StoreHallRequest $request)
    {
        $Hall = Hall::create($request->all());

        return (new HallResource($Hall))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Hall $Hall)
    {
        abort_if(Gate::denies('Hall_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HallResource($Hall->load(['hall']));
    }

    public function update(UpdateHallRequest $request, Hall $Hall)
    {
        $Hall->update($request->all());

        return (new HallResource($Hall))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Hall $Hall)
    {
        abort_if(Gate::denies('Hall_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $Hall->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
