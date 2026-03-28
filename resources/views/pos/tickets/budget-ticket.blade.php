<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            width: 200px;
            margin: 0;
            padding: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .company-info {
            font-size: 10px;
            color: #333;
        }
        .divider {
            border-top: 1px dashed #333;
            margin: 8px 0;
        }
        .ticket-info {
            margin-bottom: 10px;
        }
        .ticket-number {
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }
        .date-info {
            font-size: 10px;
            text-align: center;
        }
        .items-table {
            width: 100%;
            margin: 10px 0;
        }
        .item-row {
            margin-bottom: 8px;
        }
        .item-header {
            font-weight: bold;
            border-bottom: 1px solid #333;
            padding-bottom: 3px;
            margin-bottom: 5px;
        }
        .item-name {
            font-weight: bold;
            font-size: 11px;
        }
        .item-details {
            font-size: 10px;
            color: #555;
        }
        .item-price {
            text-align: right;
            font-size: 11px;
        }
        .item-subtotal {
            text-align: right;
            font-weight: bold;
        }
        .totals {
            margin-top: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .total-label {
            font-size: 10px;
        }
        .total-value {
            font-weight: bold;
        }
        .grand-total {
            font-size: 14px;
            border-top: 2px solid #333;
            padding-top: 5px;
            margin-top: 5px;
        }
        .bcv-note {
            font-size: 9px;
            background-color: #f5f5f5;
            padding: 5px;
            margin: 10px 0;
            border-radius: 2px;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $companyName }}</div>
        <div class="company-info">{{ $companyAddress }}</div>
        <div class="company-info">Telf: {{ $companyPhone }}</div>
    </div>

    <div class="divider"></div>

    <div class="ticket-info">
        <div class="ticket-number">{{ $budget->budget_number }}</div>
        <div class="date-info">
            {{ $budget->created_at->format('d/m/Y') }} - {{ $budget->created_at->format('H:i') }}
        </div>
    </div>

    <div class="divider"></div>

    <div class="items-table">
        <div class="item-header">
            <span style="float:left">Cant x Descripción</span>
            <span style="float:right">Total</span>
        </div>
        
        @foreach($budget->items as $item)
        <div class="item-row">
            <div class="item-name">
                {{ $item->quantity }} x {{ $item->name }}
            </div>
            <div class="item-details">
                {{ number_format($item->unit_price_bs, 2, ',', '.') }} Bs/u
            </div>
            <div class="item-price item-subtotal">
                {{ number_format($item->subtotal_bs, 2, ',', '.') }} Bs
            </div>
        </div>
        @endforeach
    </div>

    <div class="divider"></div>

    <div class="totals">
        <div class="total-row">
            <span class="total-label">Subtotal:</span>
            <span class="total-value">{{ number_format($budget->subtotal_bs, 2, ',', '.') }} Bs</span>
        </div>
        
        <div class="bcv-note">
            <div>Tasa BCV: {{ number_format($bcvRate, 2, ',', '.') }} Bs/USD</div>
            <div>Total USD: ${{ number_format($budget->subtotal_usd, 2, ',', '.') }}</div>
        </div>

        <div class="total-row grand-total">
            <span class="total-label">TOTAL BS:</span>
            <span class="total-value">{{ number_format($budget->total_bs, 2, ',', '.') }} Bs</span>
        </div>
    </div>

    <div class="divider"></div>

    <div class="footer">
        <p>Gracias por su preferencia</p>
        <p>Este presupuesto tiene vigencia de 30 días</p>
    </div>
</body>
</html>
