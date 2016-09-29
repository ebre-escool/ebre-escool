<template>
    <div id="editable_table_{{ table }}"><slot></slot></div>
</template>
<script>
    export default {

        props: {
            'table': {
                type: String,
                default: ''
            },
            'modelClass': {
                type: String,
                default: ''
            },
            'id': {
                type: Number,
                default: null
            },
            'model': {
                type: Object,
                default: function () {
                    return { "model": "", "id": null };
                }
            },
        },

        computed: {

            computedModelClass: function() {
                if (this.model.model.trim()) {
                    return this.model.model;
                }
                if (this.modelClass.trim()) {
                    return this.modelClass;
                }
            },

            tableid: function() {
                if (this.model.id != null) {
                    return this.model.id;
                }
                if (this.id != null) {
                    return this.id;
                }
            },

        },

        ready() {
            this.validate();
            this.notify();
        },

        methods : {

            validate : function() {
                this.validateId();
                this.validateTable();
            },

            validateId : function() {
                if ( this.id == null && this.model.id == null) {
                    throw 'Id or model property are required';
                }
            },

            validateTable : function() {
                if ( !this.table.trim() && ! this.model.model.trim()) {
                    throw 'Table or model property are required';
                }
            },

            notify : function() {
                if (this.table.trim()) {
                    this.$broadcast('set-table', this.table)
                }
                this.$broadcast('set-modelClass', this.computedModelClass)
                this.$broadcast('set-id', this.tableid)
            }
        }

    }
</script>
