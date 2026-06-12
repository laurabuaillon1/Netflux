<script setup>
defineProps({
    movie: {
        type: Object,
        required: true
    },
    genre: {
        type: Object,
        required: true

    }
});

</script>
<template>
    <div>
        <h2>{{ movie.title }}</h2>
        <p>{{ movie.release_date }}</p>
        <p>{{ movie.duration }}</p>
        <p>{{ genre.name }}</p>
        <div class="action">
            <router-link :to="`/movies/${movie.id}`">Informations</router-link>
            <!-- <router-link :to="`/edit/`" -->
        </div>
    </div>
</template>

<style scoped></style>