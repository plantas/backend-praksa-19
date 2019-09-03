<?php


namespace AppBundle\Service;


interface DataStorageInterface
{

    /**
     * Save a document
     *
     * Document is defined by following keys: `dataSourceId`, `entityClass`, `entityId` and `feedType`, value is array.
     *
     * @param int    $dataSourceId source id key
     * @param string $entityClass  entity class key
     * @param array  $selector     entity selector
     * @param string $feedType     feed type
     * @param array  $propertyMap  property map to save
     *
     * @return bool true if document is successfully saved, false otherwise
     */
    public function set(int $dataSourceId, string $entityClass, array $selector, string $feedType, array $propertyMap): bool;

    /**
     * Get a document
     *
     * Returns a document with specified keys.
     *
     * @param int    $dataSourceId source id key
     * @param string $entityClass  entity class key
     * @param array  $selector     entity selector
     * @param string $feedType     feed type key
     *
     * @return array|null document if it exists, null otherwise
     */
    public function get(int $dataSourceId, string $entityClass, array $selector, string $feedType): ?array;

    /**
     * Delete a document with specified keys from storage.
     *
     * @param int    $dataSourceId source id key
     * @param string $entityClass  entity class key
     * @param array  $selector     entity selector
     * @param string $feedType     feed type
     *
     * @return bool true if document is successfully deleted, false otherwise
     */
    public function delete(int $dataSourceId, string $entityClass, array $selector, string $feedType): bool;
}