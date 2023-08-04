<?php
namespace App\Interfaces;

/**
 * Documentation Interface
 * This interface defines the contract for retrieving documentaion.
 *
 * @author AungKyawPaing
 * @create 03/07/2023
 */
interface DocumentationInterface
{
    /**
     * Get the documentations of a specific project that employee is working.
     * @author AungKyawPaing
     * @create 02/07/2023
     * @param int $id.
     * @return array
     */
    public function getDocumentations($empId);
}
