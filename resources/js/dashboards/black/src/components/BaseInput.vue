<template>
    <md-field :class="{ 'md-invalid': getValidationClass }">
        <label v-html="label"></label>
        <md-input
            v-if="type === 'text'"
            :value="value"
            @input="handleInput"
            :maxlength="hasMaxLen ? validation.$params.maxLength.max : null"
        />
        <md-textarea
            v-if="type === 'textarea'"
            :value="value"
            @input="handleInput"
            md-autogrow
            :maxlength="hasMaxLen ? validation.$params.maxLength.max : null"
        >
        </md-textarea>
        <i class="md-icon tim-icons" :class="icon"></i>
        <span class="md-helper-text" v-html="description"></span>

        <span class="md-error" v-if="isRequired && !validation.required">لطفا {{ label }} را وارد کنید</span>
        <span class="md-error" v-if="hasMinLen && !validation.minLength">{{ label }} باید حداقل {{ validation.$params.minLength.min }} کاراکتر باشد</span>
        <span class="md-error" v-if="hasMaxLen && !validation.maxLength">{{ label }} باید حداکثر {{ validation.$params.maxLength.max }} کاراکتر باشد</span>
    </md-field>
</template>

<script>

export default {
    props: {
        value: {
            type: String,
            required: true
        },
        validation: {
            type: Object,
            required: true
        },
        type: {
            type: String,
            default: 'text'
        },

        // Descriptive props
        label: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true
        },
        description: {
            type: String,
            default: null
        }
    },

    computed: {

        getValidationClass()
        {
            return this.validation.$invalid && this.validation.$dirty
        },

        isRequired()
        {
            return this.validation.$params.required ? true : false
        },

        hasMaxLen()
        {
            return this.validation.$params.maxLength ? true : false
        },

        hasMinLen()
        {
            return this.validation.$params.minLength ? true : false
        },
    },

    methods: {
        
        handleInput(value)
        {
            this.validation.$touch()

            this.$emit('input', value)
        }
    }
}
</script>