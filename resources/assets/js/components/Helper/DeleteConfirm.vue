<template>
    <a :class="styleClass === undefined ? 'btn btn-xs btn-danger' : styleClass" @click="destroy(item)" data-toggle="tooltip" data-placement="top" title="Устгах" v-tip>
        <i class="fa fa-trash-o"></i>
    </a>
</template>

<script>

    export default {
        props: ['item', 'url', 'styleClass'],

        methods: {
            destroy(item)
            {
                var self = this;

                swal({
                    title: "Та итгэлтэй байна уу?",
                    text: "Устгах гэж байна! Та итгэлтэй байна уу?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Тийм",
                    cancelButtonText: "Үгүй",
                    closeOnConfirm: false
                },
                function(){
                    axios.delete(self.url).then(response => {
                        if(response.data.result)
                        {
                            swal({
                                title: 'Амжилттай!',
                                text: 'Aмжилттай устгагдлаа',
                                type: 'success',
                                confirmButtonText: "Хаах"
                            }, function(){
                                self.$emit('destroyed');
                            })
                        }
                    }).catch(error => {
                        let errors = error.response.data;
                        swal(
                            'Уучлаарай',
                            errors.message,
                            'error'
                        );
                    });
                });
            }
        }
    }

</script>