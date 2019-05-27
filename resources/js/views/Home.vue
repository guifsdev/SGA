<template>
	<h1>Home</h1>
</template>

<script>
	export default {
		mounted: function() {
			this.$emit('tabChanged', 'Home');
		}
	}
</script>