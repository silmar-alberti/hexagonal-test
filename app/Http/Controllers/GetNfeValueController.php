<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Modules\GetNfeValue\GetNfeAdapter;
use App\Http\Controllers\BaseController;
use Core\Modules\GetNfeValue\Rule\GetNfeByKeyRule;
use Core\Modules\GetNfeValue\UseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GetNfeValueController extends BaseController
{
    public function __construct(
        private GetNfeAdapter $getNfeAdapter,
    ) {
    }

    public function __invoke(string $nfeKey)
    {
        $useCase = new UseCase(
            new GetNfeByKeyRule($this->getNfeAdapter)
        );

        $nfeValue = $useCase->execute($nfeKey);

        if (null === $nfeValue) {
            return new JsonResponse([
                'message' => "Nfe with key '{$nfeKey}' not found",
                'status' => false,
                'data' => []
            ], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'status' => true,
            'message' => 'success',
            'data' => [
                'value' => $nfeValue
            ]
        ]);
    }
}
