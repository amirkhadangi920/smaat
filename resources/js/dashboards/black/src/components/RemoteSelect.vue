<template>
    <div :style="{ position: 'relative' }" class="remote-select">
        <label class="remote-select-label" :class="{ 'has-focus' : hasFocus || hasValue }">{{ label }}</label>
        <el-select
            class="col-12 remote-select"
            :value="value"
            @input="handleInput"
            :multiple="multiple"
            filterable
            remote
            clearable
            reserve-keyword
            placeholder=""
            :remote-method="remoteMethod"
            :loading="loading"
            @focus="hasFocus = true"
            @blur="hasFocus = false"
            @clear="handleClear"
            loading-text="در حال جستجو ..."
            no-data-text="داده ای یافت نشد :("
        >
            <el-option
                v-for="item in options"
                :key="item.id"
                :label="item[labelfield]"
                :value="item.id"
            >
                <slot name="content" :item="item"></slot>
            </el-option>
        </el-select>
        <span class="md-helper-text" :style="{ fontSize: '12px' }">{{ placeholder }}</span>
        <i class="remote-select-icon md-icon tim-icons" :class="icon"></i>
    </div>
</template>

<script>
import _ from 'lodash'

export default {
    props: {
        value: {
            required: true
        },
        // validation: {
        //     type: Object,
        //     required: true
        // },
        type: {
            type: String,
            required: true
        },
        fields: {
            type: String,
            required: true
        },
        filters: {
            type: String,
        },
        multiple: {
            type: Boolean,
            default: false
        },

        // Descriptive props
        label: {
            type: String,
            required: true
        },
        labelfield: {
            type: String,
            default: () => 'title'
        },
        defaults: {
            type: Array,
            default: () => []
        },
        placeholder: {
            type: String,
            default: () => ''
        },
        icon: {
            type: String,
            default: () => ''
        }
    },

    data()
    {
        return {
            hasFocus: false,
            options: this.defaults.filter(i => i && i.id),
            loading: false,

            default_data: []
        }
    },

    computed: {

        hasValue()
        {
            if ( this.multiple )
                return this.value.length !== 0

            else
                return this.value !== null
        },

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

    mounted() {
        this.loading = true

        axios.post('/graphql/auth', {
            query: `{
                allData: ${this.type} (per_page: 30 ${ this.filters ? ',' + this.filters : ''}) {
                    data {
                        id
                        ${this.fields}
                    }
                }
            }`
        })
        .then(({data}) =>
        {   
            this.loading = false;

            const DATA = _.uniqBy([ ...this.defaults.filter(i => i && i.id), ...data.data.allData.data ], 'id')

            this.default_data = DATA
            this.options = DATA;
        })
    },

    methods: {

        handleClear()
        {
            this.$emit('input', this.multiple ? [] : null)
            this.hasFocus = false
        },

        handleInput(value)
        {
            this.options = _.differenceBy(this.options, this.defaults, 'id')

            this.$emit('input', value)
        },
        
        remoteMethod(query)
        {
            if (query !== '' && query.length >= 3)
            {
                this.loading = true;

                axios.post('/graphql/auth', {
                    query: `{
                        allData: ${this.type} (query: "${query}" ${ this.filters ? ',' + this.filters : ''}) {
                            data {
                                id
                                ${this.fields}
                            }
                        }
                    }`
                })
                .then(({data}) =>
                {
                    this.loading = false;

                    this.options = _.uniqBy([ ...this.defaults.filter(i => i && i.id), ...data.data.allData.data ], 'id');
                })

            } else {
                this.options = _.uniqBy(this.default_data, 'id');
            }
        }
    }
}
</script>

<style>

.el-scrollbar .el-select-dropdown__wrap {
    direction: rtl;
    text-align: right;
    padding: 0px 15px;
}

.el-select-dropdown.is-multiple .el-select-dropdown__item.selected::after {
    right: auto;
    left: 10px;
}

.remote-select-icon {
    float: left;
    margin-top: -36px;
    font-size: 20px !important;
    margin-left: 0px;
}

label.remote-select-label {
    position: absolute;
    top: 16px;
    pointer-events: none;
    transition: .4s cubic-bezier(.25,.8,.25,1);
    transition-duration: .3s;
    font-size: 16px;
    line-height: 20px;
}

label.remote-select-label.has-focus {
    top: -5px;
    font-size: 12px;
}

.el-select-dropdown {
    margin-left: -17px;
}

.el-select.remote-select {
    border: none;
    border-bottom: 1px solid #878787;
    border-radius: 0px;
    padding-right: 1px;
}

.el-select.remote-select .el-select__caret.el-input__icon.el-icon-circle-close {
    margin-right: -30px;
}

.el-select.remote-select .el-tag__close.el-icon-close {
    right: 0px;
}

.el-select.remote-select input {
    padding-right: 0px !important;
    background: transparent;
}

.el-select-dropdown__item {
    border-bottom: 0.1px solid #e9e9e9;
}

.el-select-dropdown__item:last-of-type {
    border-bottom: none;
}

</style>