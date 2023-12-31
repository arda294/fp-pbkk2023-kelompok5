<?php
namespace App\Http\Modules\Review\Domain\Service\Repository;

use App\Http\Modules\Review\Domain\Models\ProductReview;

interface ProductReviewRepositoryInterface
{
    public function index(int $product_id = 0);
    public function getById(int $product_review_id);
    public function deleteById(int $product_review_id);
    public function persist(ProductReview $user);
}