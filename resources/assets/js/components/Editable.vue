<template>
    <div>
        <div>Content: {{ content }}</div>
        <label class="control-label" v-if="!editing" @dblclick="toogleEditing" id="label">
            <slot>Error! Use editable with content!</slot>
            <i class="fa fa-edit" style="color: green;" v-if="!editing" @click="toogleEditing"></i>
        </label>
        <div class="input-group" v-if="editing">
            <input v-focus type="text" class="form-control" v-model="content"
                   @keyup.esc="toogleEditing" @keyup.enter="save" onFocus="this.select();">
            <div class="input-group-addon bg-green">
                <i class="fa fa-check" @click="save"></i>
            </div>
            <div class="input-group-addon bg-red">
                <i class="fa fa-remove" @click="toogleEditing"></i>
            </div>
        </div>
    </div>
</template>

<script>

    var focusDirective = {
        bind: function() {
            Vue.nextTick(function() {
                this.el.focus();
            }.bind(this));
        }
    };

    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                editing: false,
                content: ""
            };
        },

        ready() {
            this.content = this.getContent();
            console.log('Editable Component is ready!');
            this.$http.get('/api/user12')
                    .then(response => {
                    console.log(response.data);
            }, response => {
                    console.log('Error!');
//                    toastr.info('Are you the 6 fingered man?')
            });
            console.log('HEY!');
        },

        directives: {
            'focus': focusDirective
        },

        methods: {
            /**
             * Toogle edit state
             */
            toogleEditing() {
                this.editing = !this.editing;
            },

            /**
             * Save change
             */
            save() {
                this.toogleEditing();
            },

            /**
             * Escape form editing
             */
            escape() {
                console.log('ESCAPE is pressed!');
                if (this.editing) {
                    this.toogleEditing();
                }
            },

            /**
             * Get content
             */
            getContent() {
                return this.$el.querySelector('#label').textContent.trim();
            },
        }
    }
</script>
