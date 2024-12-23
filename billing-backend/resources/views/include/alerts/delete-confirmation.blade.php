<!-- Modal -->
<div class="modal fade" id="ModalDelete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ModalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header border-0 h-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('assets/img/warning.svg') }}" alt="warning" class="warning_icon">
                <h4 class="modal-title mb-2" id="ModalDeleteLabel">Are you sure?</h4>
                <p id="customConfirmationMessage">You want to delete this information permanently.</p>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">No</button>
                    <button type="button" id="confirmDelete" class="btn btn-danger btn-width">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>