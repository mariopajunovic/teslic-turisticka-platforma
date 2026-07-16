import { reactive } from 'vue';

const state = reactive({ items: [] });
let seq = 0;

export function useToast() {
    const dismiss = (id) => {
        const i = state.items.findIndex((t) => t.id === id);
        if (i !== -1) state.items.splice(i, 1);
    };

    const push = (title, sub = null, tip = 'ok') => {
        const id = ++seq;
        state.items.push({ id, title, sub, tip });
        setTimeout(() => dismiss(id), 4500);
        return id;
    };

    return { state, push, dismiss };
}
