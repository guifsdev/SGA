<template>
  <div>
    <h1>Hello {{guard}}</h1>
    <p>Your data is: {{data}}</p>
  </div>
</template>

<script>
export default {
  props: ['data', 'guard'],

  mounted: function() {
    console.log(this.data);
  }
}
</script>

<style>

</style>
