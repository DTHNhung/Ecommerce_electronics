<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-action" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">
                    {{ __('titles.change-status') }}
                </h5>
            </div>
            <form action="{{ route('orders.update') }}" method="POST" id="form_edit_order">
                @csrf
                @method("PATCH")
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <select class="form-control" id="statusOrder"
                            name="status">
                            <option id="optionFirstStatus">
                            </option>
                            <option id="optionSecondStatus">
                            </option>
                        </select>
                        <input type="hidden" name="id" value="" id="order_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit_edit_order" class="btn btn-primary add_voucher">
                        {{ __('titles.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Edit Voucher Modal -->
