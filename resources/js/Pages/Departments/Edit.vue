<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({ department: {type: Object}});
const form = useForm({
  name: props.department.name
});


</script>

<template>
  <Head title="Edit Department" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Department</h2>
    </template>

    <div class="py-12">
      <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <form @submit.prevent="$event => form.put(route('departments.update', department))" class="mt-6 space-y-6 max-w-xl">
              <InputLabel for="name" value="Department" />
              <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
              <InputError class="mt-2" :message="form.errors.name" />
              <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                <i class="fa-solid fa-save"></i> Save
                </PrimaryButton>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>