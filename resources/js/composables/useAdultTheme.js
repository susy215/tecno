import { ref, onMounted } from 'vue';

const isAdult = ref(localStorage.getItem('isAdult') === 'true');

function updateBodyClass() {
  if (isAdult.value) {
    document.body.classList.add('theme-adult');
  } else {
    document.body.classList.remove('theme-adult');
  }
}

function toggleAdult() {
  isAdult.value = !isAdult.value;
  localStorage.setItem('isAdult', isAdult.value);
  updateBodyClass();
}

export function useAdultTheme() {
  onMounted(updateBodyClass);
  return {
    isAdult,
    toggleAdult
  };
}
