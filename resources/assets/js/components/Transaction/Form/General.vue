<template>
    <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" v-modal v-on:showModal="init()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="transactionModalLabel">Ажил гүйлгээ шинээр бүртгэх</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Баримтын дугаар</label>
                                        <input type="text" class="form-control input-sm"  />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Огноо</label>
                                        <input type="text" class="form-control input-sm"  />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Харилцагч</label>
                                        <input type="text" class="form-control input-sm"  />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Данс</label>
                                        <input type="text" class="form-control input-sm"  />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Харицах данс</label>
                                        <input type="text" class="form-control input-sm"  />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Гүйлгээний утга</label>
                                        <input type="text" class="form-control input-sm"  />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Кр / Дб</label>
                                        <input type="text" class="form-control input-sm"  />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Мөнгөн дүн</label>
                                        <input type="text" class="form-control input-sm"  />
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>