<template>
    <a class="btn btn-xs btn-danger" @click="destroy(item)">
        <i class="fa fa-trash-o"></i>
    </a>
</template>

<script>

    export default {
        props: ['item', 'url'],

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
                                type: 'success'
                            }, function(){
                                self.$emit('destroyed');
                            })
                        }
                    }).catch(function(error) {
                        swal(
                            'Уучлаарай',
                            'Хүсэлт амжилтгүй боллоо! Та дахин оролдоно уу.',
                            'error'
                        );
                    });
                });
            }
        }
    }

</script>