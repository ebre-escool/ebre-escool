<template>
    <div :id="'editable_field_' + fieldname">
        <!--<div>Content: {{ content }}</div>-->
        <!--<div>Field: {{ field | json }}</div>-->
        <!--<div>Field Name: {{ fieldname }}</div>-->
        <!--<div>Table Name: {{ tablename }}</div>-->
        <!--<div>Field Id : {{ tableid }}</div>-->
        <!--<div>Model name : {{ modelname }}</div>-->
        <!--<div>Refresh : {{ refresh }}</div>-->
        <!--<div>Editing : {{ editing }}</div>-->

        <label class="control-label" v-if="!editing" @dblclick="toogleEditing" id="label">
            {{ content }}
            <i class="fa fa-edit" style="color: green;" v-if="!editing" @click="toogleEditing"></i>
            <i class="fa fa-refresh" style="color: green;" v-if="refresh" @click="refreshContent"></i>
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
                editing: false
            };
        },

        props: {
            'field' : {
                type: Object,
                default: function () {
                    return { "name": "", "model": "", "id": null };
                }
            },
            'name'  : {
                type: String,
                default: ""
            },
            'table'  : {
                type: String,
                default: ""
            },
            'model'  : {
                type: String,
                default: ""
            },
            'id'  : {
                type: Number,
                default: null
            },
            'content'  : {
                type: String,
                default: ""
            },
            'refresh'  : {
                type: Boolean,
                default: false
            },
        },

        computed: {

            fieldname: function () {
                if (this.name.trim()) {
                    return this.name;
                }
                if (this.field.name.trim()) {
                    return this.field.name;
                }
                throw "Impossible to obtain fieldname. Use name or field prop to set field name";
            },

            modelname: function () {
                if (this.field.model.trim()) {
                    return this.field.model;
                }
                if (this.model.trim()) {
                    return this.model;
                }
            },

            tableid: function() {
                if (this.field.id != null) {
                    return this.field.id;
                }
                if (this.id != null) {
                    return this.id;
                }
            },

        },

        ready() {
            if ( ! this.content.trim()) {
                this.content = this.getContent();
            }
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

            refreshContent() {
                //TODO: SHOW REFRESH CHANGING ICON to spinning action
                console.log("REFRESH!!!!!!!!");
                this.$http.post('api/editable/refresh',this.prepareRefreshFormData())
                    .then(response => {
                        console.log(response.data);
                    }, response => {
                        toastr.info('Error refreshing! Error ' + response.status + ' ' + response.statusText);
                    });
                //TODO: stop spinning!
            },

            /**
             * Save change
             */
            save() {
                this.$http.post('api/editable/save',this.prepareSaveFormData())
                    .then(response => {
                        console.log(response.data);
                }, response => {
                    toastr.info('Error saving! Error ' + response.status + ' ' + response.statusText);
                });
                this.toogleEditing();
            },

            /**
             * Prepare Common form data
             */
            prepareCommonFormData() {
                let formData = new FormData();
                formData.append('content', this.content);
                formData.append('fieldname', this.fieldname);
                if (this.table.trim()) {
                    formData.append('tablename', this.table);
                }
                if (this.modelname.trim()) {
                    formData.append('model', this.modelname);
                }
                formData.append('tableid', this.tableid);
                return formData;
            },

            /**
             * Prepare refresh form data
             */
            prepareRefreshFormData() {
                return this.prepareCommonFormData();
            },

            /**
             * Prepare Save form data
             */
            prepareSaveFormData() {
                let formData = this.prepareCommonFormData();
                formData.append('content', this.content);
                return formData;
            },

            /**
             * Escape form editing
             */
            escape() {
                if (this.editing) {
                    this.toogleEditing();
                }
            },

            /**
             * Get content
             */
            getContent() {
                return this._slotContents['default'].textContent;
            },

        },

        events: {
            'set-table': function (table) {
                if (!this.table.trim()) {
                    this.table = table;
                }
            },

            'set-id': function (id) {
                if (this.id == null) {
                    this.id = id;
                }
            },

            'set-modelClass': function (model) {
                if (!this.model.trim()) {
                    this.model = model;
                }
            },
        }

    }
</script>
