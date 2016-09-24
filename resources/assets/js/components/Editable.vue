<template>
    <label class="control-label"><slot>Error use editable with content!</slot> <i class="fa fa-edit" style="color: green;"></i></label>
    <div class="input-group" style="display: none;">
        <input type="text" class="form-control" value="{{ $user->contact()->firstname or '' }}">
        <div class="input-group-addon bg-green">
            <i class="fa fa-check"></i>
        </div>
        <div class="input-group-addon bg-red">
            <i class="fa fa-remove"></i>
        </div>
    </div>
</template>

<script>
    export default {
        ready() {
            console.log('Editable Component is ready!');
            this.$http.get('/api/user')
                    .then(response => {
                    console.log('Resposta');
                    console.log(response.data);
            });
            console.log('PROVA!');
        }
    }
</script>
