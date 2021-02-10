<template lang="">
    <div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="deleteModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center ">
                            <div class="text-danger display-4">
                                <i
                                    style="border: 2px solid red;"
                                    class="fas fa-trash p-3 rounded"
                                ></i>
                            </div>
                            <h3>Are you sure?</h3>
                            <p>
                                Do you really want to delete these records? This
                                process cannot be undone.
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button :loading="isDeleting=true" type="button" class="btn btn-danger">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {};
</script>
<style lang=""></style>
