<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $transaction->user_detail->full_name() }} - Transaction Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            @foreach ($transaction->fund_detail as $all_transactions)
            <div class="col-6 mb-2">
                <div class="card">
                    <div class="card-header @if($all_transactions->status == 'Verified') bg-success @else bg-warning @endif  text-white">
                        <h4 class="card-title">
                            {{ $all_transactions->status }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @if ($all_transactions->file)
                            <img src="{{ profile_asset($all_transactions->file) }}" class='img-fluid' />
                        @endif
                        <hr />
                        <p>
                        <strong>Full Name: </strong> {{ $all_transactions->user_detail->full_name() }}
                        <br />
                        <strong>Phone:</strong> {{ $all_transactions->user_detail->phone_number }}
                    </p>
                    <p>
                        <strong>Deposit Source: </strong>{{ $all_transactions->source }}
                        <br />
                        <strong>Amount:</strong> NRs. {{ number_format($all_transactions->amount, 2) }}
                        <br />
                        <strong>Reference Number: {{ $all_transactions->reference_number }}</strong>
                        <br />
                        <strong>Owner Remark:</strong> {{ $all_transactions->owner_remarks }}
                    </p>
                    <p>
                        <strong>Status:</strong>{{ ucwords($all_transactions->status) }}
                        <br />
                        <strong>Admin Remark:</strong> {{ $all_transactions->admin_remarks }}
                    </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>    
</body>
</html>