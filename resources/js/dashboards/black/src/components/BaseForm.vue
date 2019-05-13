<template>
    <div>
        <slot></slot>
    </div>
</template>

<script>

export default {
    props: {
        // value: {
        //     type: String,
        //     required: true
        // },
        validation: {
            type: Object,
            required: true
        },
        // valid: {
        //     type: Boolean,
        //     required: true
        // }
    },

    mounted() {
        // console.log( this.validation )
    },

    computed: {
        // 
    },

    methods: {
        //
    }
}
</script>