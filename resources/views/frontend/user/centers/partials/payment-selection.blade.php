<form action="" method="get">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="">Please select one of the following payment Method</label>
                <select name="paymentOpt" id="payment" class="form-control">
                    <option value="esewa">E-Sewa</option>
                    <option value="voucher">Bank Voucher deposit</option>
                    <option value="fonepay" disabled>F-One Scan</option>
                    <option value="ibs" disabled>Internet Banking</option>
                    <option value="ip_bank">Internation Payment (Bank Deposit)</option>
                    <option value="ip_cash">Internation Payment (Cash)</option>
                    <option value="ip_op">Internation Payment (Online Payment)</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-3 div col-md-4">
        <button type="submit" class="btn btn-success">Confirm Payment Option</button>
    </div>
</form>