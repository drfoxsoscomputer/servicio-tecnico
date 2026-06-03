<?php

namespace App\Services;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductVariantService
{
    /**
     * Genera variantes por matriz (Producto Cartesiano).
     * 
     * @param Product $product El producto padre
     * @param array $attributeGroups Un array de grupos de IDs de valores [attr_id => [val_id1, val_id2]]
     * @return int Cantidad de variantes creadas
     */
    public function generateMatrix(Product $product, array $attributeGroups): int
    {
        // 1. Limpiamos grupos que no tengan selección
        $groups = array_filter($attributeGroups, fn($values) => !empty($values));
        
        if (empty($groups)) {
            return 0;
        }

        // 2. Calculamos el Producto Cartesiano (la magia de Laravel)
        $combinations = Arr::crossJoin(...array_values($groups));
        $createdCount = 0;

        // 3. Ejecutamos la creación masiva en una transacción para mayor seguridad
        DB::transaction(function () use ($product, $combinations, &$createdCount) {
            foreach ($combinations as $combination) {
                // crossJoin puede devolver un valor simple si hay un solo grupo
                $valueIds = is_array($combination) ? $combination : [$combination];
                
                // 4. Generamos el SKU (usando la misma lógica centralizada)
                $sku = $this->generateSku($product, $valueIds);

                // 5. Verificamos duplicados (si el SKU ya existe, saltamos esta combinación)
                if (ProductVariant::where('sku', $sku)->exists()) {
                    continue;
                }

                // 6. Creamos el registro de la variante
                $variant = $product->variants()->create([
                    'sku' => $sku,
                    'price_bs' => $product->price_bs,
                    'price_usd' => $product->price_usd,
                    'is_active' => true,
                ]);

                // 7. Sincronizamos la relación muchos-a-muchos (pivote)
                $variant->variantValues()->sync($valueIds);
                
                $createdCount++;
            }
        });

        return $createdCount;
    }

    /**
     * Lógica centralizada para generar SKUs predecibles y limpios.
     */
    public function generateSku(Product $product, array $valueIds): string
    {
        // Prefijo del Producto (Primeras 4 letras + ID)
        $cleanProductName = preg_replace('/[^A-Za-z0-9]/', '', $product->name);
        $prefix = strtoupper(substr($cleanProductName, 0, 4));
        $skuParts = [$prefix . '-' . str_pad($product->id, 3, '0', STR_PAD_LEFT)];

        // Obtenemos los nombres de los valores ordenados por el ID del Atributo
        // Esto asegura que el SKU sea siempre igual sin importar el orden de selección
        $vals = AttributeValue::whereIn('attribute_values.id', $valueIds)
            ->join('variant_attributes', 'attribute_values.variant_attribute_id', '=', 'variant_attributes.id')
            ->orderBy('variant_attributes.id')
            ->select('attribute_values.*')
            ->get()
            ->pluck('name');

        foreach ($vals as $valName) {
            $cleanVal = preg_replace('/[^A-Za-z0-9]/', '', $valName);
            $skuParts[] = strtoupper(substr($cleanVal, 0, 3));
        }

        return implode('-', $skuParts);
    }
}
