import { reactive } from 'vue';

export const focusStore = reactive({
  focusedItemIndex: null,
  setFocusedItem(index) {
    this.focusedItemIndex = index;
  },
  clearFocusedItem() {
    this.focusedItemIndex = null;
  },
});
