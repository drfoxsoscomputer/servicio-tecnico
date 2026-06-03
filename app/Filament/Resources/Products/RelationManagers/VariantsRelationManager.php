<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\AttributeValue;
use App\Models\BcvRate;
use App\Models\VariantAttribute;
use App\Services\ProductVariantService;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    public ?array $tempVariantValues = [];

    protected static ?string $modelLabel = 'variante';



    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Detalles Básicos')
                            ->icon('heroicon-o-information-circle')
                            ->columns(2)
                            ->schema([
                                TextInput::make('barcode')
                                    ->label('Código de Barras')
                                    ->maxLength(255)
                                    ->helperText('Opcional. Escaneá aquí el código físico que trae la caja del producto.'),

                                Toggle::make('is_active')
                                    ->label('Variante Activa')
                                    ->default(true)
                                    ->columnSpanFull(),
                            ]),

                        
                            Tab::make('Características')
                            ->icon('heroicon-o-tag')
                            // Generación Dinámica de UI Nivel Senior
                            ->schema(function () {
                                $attributes = VariantAttribute::with(['values' => fn ($q) => $q->where('is_active', true)])
                                    ->where('is_active', true)
                                    ->get();

                                // Lógica de actualización del SKU (Blindada 7x7)
                                $updateSkuLive = function (Get $get, Set $set, $livewire) {
                                    $product = $livewire->getOwnerRecord();
                                    if (! $product) return;

                                    $productPrefix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $product->name), 0, 4));
                                    $baseSku = $productPrefix . '-' . str_pad($product->id, 3, '0', STR_PAD_LEFT);

                                    $config = $get('attributes_config') ?? [];
                                    $skuParts = [$baseSku];
                                    $hasMultipleSelections = false;

                                    foreach ($config as $item) {
                                        if (!empty($item['value_ids'])) {
                                            $ids = is_array($item['value_ids']) ? $item['value_ids'] : [$item['value_ids']];

                                            if (count($ids) > 1) { $hasMultipleSelections = true; }

                                            $names = AttributeValue::whereIn('id', $ids)->pluck('name');
                                            foreach ($names as $name) {
                                                $skuParts[] = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 3));
                                            }
                                        }
                                    }

                                    if ($hasMultipleSelections) {
                                        $set('sku', $baseSku . ' [MÚLTIPLES SELECCIONES]');
                                    } else {
                                        $set('sku', implode('-', $skuParts));
                                    }
                                };

                                $components = [];

                                $components = [];


                                $components[] = Repeater::make('attributes_config')
                                    ->label('Características')
                                    ->helperText('Agregá categorías y marcá sus valores.')
                                    ->live()
                                    ->afterStateUpdated($updateSkuLive)
                                    ->schema([
                                        Grid::make(12)
                                            ->schema([
                                                Select::make('attribute_id')
                                                    ->label('Categoría')
                                                    ->placeholder('Color, Marca...')
                                                    ->options(VariantAttribute::where('is_active', true)->pluck('name', 'id'))
                                                    ->searchable()
                                                    ->required()
                                                    ->live()
                                                    ->columnSpan(4)
                                            // CREAR CATEGORÍA NUEVA
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->label('Nombre de la Categoría Madre (Ej: Marca, Color, Capacidad)')
                                                    ->placeholder('Ej: Color')
                                                    ->required()
                                                    ->unique('variant_attributes', 'name')
                                                    ->validationMessages([
                                                        'unique' => '¡Epa! Esta categoría ya existe en el sistema. Buscala en la lista desplegable.',
                                                    ]),
                                                Repeater::make('values')
                                                    ->label('Valores Iniciales para esta Categoría')
                                                    ->schema([
                                                        TextInput::make('name')->label('Nombre del Valor (Ej: Rojo, 512GB)')->required(),
                                                    ])
                                                    ->addActionLabel('Agregar otro valor')
                                                    ->columns(1)
                                            ])
                                            ->createOptionUsing(function (array $data) {
                                                $attr = VariantAttribute::create(['name' => $data['name'], 'is_active' => true]);
                                                if (isset($data['values'])) {
                                                    foreach ($data['values'] as $v) { $attr->values()->create(['name' => $v['name'], 'is_active' => true]); }
                                                }
                                                return $attr->id;
                                            })
                                            ->suffixAction(
                                                Action::make('manage_attribute_values')
                                                    ->icon('heroicon-m-pencil-square')
                                                    ->tooltip('Editar valores de esta categoría')
                                                    ->color('warning')
                                                    ->slideOver()
                                                    ->modalWidth('md')
                                                    ->modalHeading(fn (Get $get) => 'Gestionar: ' . (VariantAttribute::find($get('attribute_id'))?->name ?? 'Categoría'))
                                                    ->schema([
                                                        TextInput::make('name')
                                                            ->label('Categoría Seleccionada')
                                                            ->disabled()
                                                            ->dehydrated(false)
                                                            ->columnSpanFull(),
                                                        Repeater::make('values_manual')
                                                            ->label('Valores Disponibles')
                                                            ->schema([
                                                                TextInput::make('name')->label('Nombre')->required(),
                                                            ])
                                                            ->grid(3)
                                                            ->addActionLabel('Agregar valor')
                                                            ->columnSpanFull()
                                                    ])
                                                    ->fillForm(function (Get $get) {
                                                        $attr = VariantAttribute::find($get('attribute_id'));
                                                        if (! $attr) return [];
                                                        return [
                                                            'name' => $attr->name,
                                                            'values_manual' => $attr->values->map(fn($v) => ['id' => $v->id, 'name' => $v->name])->toArray(),
                                                        ];
                                                    })
                                                    ->action(function (array $data, Get $get) {
                                                        $attr = VariantAttribute::find($get('attribute_id'));
                                                        if (! $attr) return;

                                                        if (isset($data['values_manual'])) {
                                                            foreach ($data['values_manual'] as $vData) {
                                                                if (isset($vData['id'])) {
                                                                    AttributeValue::find($vData['id'])?->update(['name' => $vData['name']]);
                                                                } else {
                                                                    $attr->values()->create(['name' => $vData['name'], 'is_active' => true]);
                                                                }
                                                            }
                                                        }
                                                        Notification::make()->title('¡Actualizado!')->success()->send();
                                                    })
                                                    ->visible(fn (Get $get) => filled($get('attribute_id')))
                                            ),

                                        ToggleButtons::make('value_ids')
                                            ->label('Valores / Opciones')
                                            ->options(fn (Get $get) =>
                                                AttributeValue::where('variant_attribute_id', $get('attribute_id'))
                                                    ->where('is_active', true)
                                                    ->pluck('name', 'id')
                                            )
                                            ->multiple()
                                            ->inline()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated($updateSkuLive)
                                            ->columnSpan(8)
                                            ])
                                    ])
                                    ->columns(1)
                                    ->defaultItems(1)
                                    ->addActionLabel('Añadir más')
                                    ->afterStateHydrated(function ($component, $record) {
                                        if (!$record) return;
                                        $values = $record->variantValues()->with('attribute')->get();
                                        $grouped = [];
                                        foreach ($values as $val) {
                                            $attrId = $val->variant_attribute_id;
                                            if (!isset($grouped[$attrId])) {
                                                $grouped[$attrId] = ['attribute_id' => $attrId, 'value_ids' => []];
                                            }
                                            $grouped[$attrId]['value_ids'][] = $val->id;
                                        }
                                        $component->state(array_values($grouped));
                                    });
                                // Mover el SKU acá abajo para que el usuario vea el resultado
                                $components[] = TextInput::make('sku')
                                    ->label('SKU (Código Identificador)')
                                    ->readOnly()
                                    ->maxLength(255)
                                    ->unique('product_variants', 'sku', ignoreRecord: true)
                                    ->validationMessages([
                                        'unique' => 'Ya existe una variante con esta misma combinación de características para este producto.',
                                    ])
                                    ->helperText('Código único auto-generado. Si ya existe la combinación, el sistema te avisará.')
                                    ->afterStateHydrated(function ($set, $state, $livewire, ?Model $record) {
                                        // Hidratar SKU inicial si es nuevo
                                        if (! $record || empty($state)) {
                                            $product = $livewire->getOwnerRecord();
                                            if ($product) {
                                                $cleanName = preg_replace('/[^A-Za-z0-9]/', '', $product->name);
                                                $prefix = strtoupper(substr($cleanName, 0, 4));
                                                $set('sku', $prefix.'-'.str_pad($product->id, 3, '0', STR_PAD_LEFT));
                                            }
                                        }
                                    });

                                $components[] = Actions::make([
                                    Action::make('generate_matrix')
                                        ->label('Generador Masivo de Variantes')
                                        ->icon('heroicon-m-sparkles')
                                        ->color('info')
                                        ->size('md')
                                        ->modalWidth('md')
                                        ->requiresConfirmation()
                                        ->modalHeading('🧙‍♂️ Confirmar Generación Masiva')
                                        ->modalDescription('Esto creará todas las variantes posibles usando las categorías y valores que seleccionaste arriba. ¿Continuamos?')
                                        ->modalSubmitActionLabel('Sí, crear variantes')
                                        ->action(function (Get $get, $livewire) {
                                            $record = $livewire->getOwnerRecord();
                                            $config = $get('attributes_config') ?? [];

                                            $groups = [];
                                            foreach ($config as $item) {
                                                if (!empty($item['value_ids'])) {
                                                    $ids = is_array($item['value_ids']) ? $item['value_ids'] : [$item['value_ids']];
                                                    // Nos aseguramos de mandar solo IDs únicos y limpios
                                                    $groups[] = array_unique(array_filter($ids));
                                                }
                                            }

                                            if (empty($groups)) {
                                                Notification::make()->title("Faltan datos")->body("Seleccioná categorías y valores.")->danger()->send();
                                                return;
                                            }

                                            $count = app(ProductVariantService::class)->generateMatrix($record, $groups);

                                            if ($count > 0) {
                                                Notification::make()
                                                    ->title("¡Éxito!")
                                                    ->body("Se generaron {$count} variantes correctamente.")
                                                    ->success()
                                                    ->send();

                                                // Refrescamos la relación para que la tabla muestre lo nuevo
                                                $livewire->dispatch('refreshRelationManager');
                                            } else {
                                                Notification::make()
                                                    ->title("Sin cambios")
                                                    ->body("No se crearon variantes nuevas (posiblemente ya existen todas las combinaciones).")
                                                    ->warning()
                                                    ->send();
                                            }
                                        }),
                                ])->alignRight();

                                return $components;
                            }),

                        Tab::make('Precios')
                            ->icon('heroicon-o-currency-dollar')
                            ->columns(2)
                            ->schema([
                                TextInput::make('price_bs')
                                    ->label('Precio Bs.')
                                    ->numeric()
                                    ->prefix('Bs.')
                                    ->placeholder('0,00')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (!$state) return;
                                        // Limpieza: si tiene coma, es formato ven; si no, es número limpio
                                        $clean = str_contains($state, ',')
                                            ? str_replace(',', '.', str_replace('.', '', $state))
                                            : str_replace(',', '.', $state);
                                        $value = (float) $clean;

                                        $rate = \App\Models\BcvRate::getCurrentRate();
                                        $set('price_usd', round($value / $rate, 2));
                                    }),

                                TextInput::make('price_usd')
                                    ->label('Precio $USD')
                                    ->numeric()
                                    ->prefix('$')
                                    ->placeholder('0,00')
                                    ->hint('Tasa: ' . number_format(\App\Models\BcvRate::getCurrentRate(), 2, ',', '.') . ' Bs.')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (!$state) return;
                                        $clean = str_contains($state, ',')
                                            ? str_replace(',', '.', str_replace('.', '', $state))
                                            : str_replace(',', '.', $state);
                                        $value = (float) $clean;

                                        $rate = \App\Models\BcvRate::getCurrentRate();
                                        $set('price_bs', round($value * $rate, 2));
                                    }),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sku')
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('variantValues.name')
                    ->label('Atributos')
                    ->badge()
                    ->formatStateUsing(fn ($state, $record) => $state)
                    ->separator(','),
                TextColumn::make('price_bs')
                    ->label('Precio/Bs')
                    ->numeric(decimalPlaces: 2, decimalSeparator: ',', thousandsSeparator: '.')
                    ->prefix('Bs. ')
                    ->sortable(),
                TextColumn::make('price_usd')
                    ->label('Precio/USD')
                    ->numeric(decimalPlaces: 2, decimalSeparator: ',', thousandsSeparator: '.')
                    ->prefix('$ ')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->slideOver()
                    ->stickyModalFooter()
                    ->visible(true)
                    ->mutateFormDataUsing(function (array $data): array {
                        // Procesar el repetidor para extraer todos los IDs de valores
                        $allValueIds = [];
                        if (isset($data['attributes_config'])) {
                            foreach ($data['attributes_config'] as $item) {
                                if (!empty($item['value_ids'])) {
                                    $ids = is_array($item['value_ids']) ? $item['value_ids'] : [$item['value_ids']];
                                    $allValueIds = array_merge($allValueIds, $ids);
                                }
                            }
                        }
                        $data['temp_sync_values'] = $allValueIds;
                        unset($data['attributes_config']);
                        return $data;
                    })
                    ->after(function ($record, array $data) {
                        if (isset($data['temp_sync_values'])) {
                            $record->variantValues()->sync($data['temp_sync_values']);
                        }
                    }),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver()
                    ->stickyModalFooter()
                    ->mutateFormDataUsing(function (array $data): array {
                        $allValueIds = [];
                        if (isset($data['attributes_config'])) {
                            foreach ($data['attributes_config'] as $item) {
                                if (!empty($item['value_ids'])) {
                                    $ids = is_array($item['value_ids']) ? $item['value_ids'] : [$item['value_ids']];
                                    $allValueIds = array_merge($allValueIds, $ids);
                                }
                            }
                        }
                        $data['temp_sync_values'] = $allValueIds;
                        unset($data['attributes_config']);
                        return $data;
                    })
                    ->after(function ($record, array $data) {
                        if (isset($data['temp_sync_values'])) {
                            $record->variantValues()->sync($data['temp_sync_values']);
                        }
                    }),
                DissociateAction::make(),
                DeleteAction::make()
                    ->visible(true),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
