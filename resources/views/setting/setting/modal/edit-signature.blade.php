<div class="modal fade" id="editSignatureModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Edit Signature
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="signatureContainer" hidden>
                   
                </div>
                <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Update Signature Here</legend>
                    <div id="signature-pad" class="m-signature-pad">
                        <div class="m-signature-pad--body">
                            <canvas id="canvas" width="450" height="150"></canvas>
                            <span  style="color:red;" class="message_error text-red block signature_error"></span>
                        </div>
                    </div>
                </fieldset>

             
            </div>
            <div class="modal-footer justify-content-end">
                <button id="clear" class="btn btn-warning btn-sm" style="float: right" title="Reset">
                    <i class="fa-solid fa-rotate-right"></i>
                </button>
                <button id="btnSaveSignature" type="button" class="btn btn-success btn-sm" title="Save Signature">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>