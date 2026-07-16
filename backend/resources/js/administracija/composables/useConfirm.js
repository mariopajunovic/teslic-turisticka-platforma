import { reactive } from 'vue';

const state = reactive({
    open: false,
    title: '',
    message: '',
    danger: false,
    confirmLabel: 'Potvrdi',
    cancelLabel: 'Odustani',
    _resolve: null,
});

export function useConfirm() {
    const confirm = (opts = {}) =>
        new Promise((resolve) => {
            state.title = opts.title ?? 'Potvrda';
            state.message = opts.message ?? '';
            state.danger = opts.danger ?? false;
            state.confirmLabel = opts.confirmLabel ?? (state.danger ? 'Obriši' : 'Potvrdi');
            state.cancelLabel = opts.cancelLabel ?? 'Odustani';
            state.open = true;
            state._resolve = resolve;
        });

    const respond = (val) => {
        state.open = false;
        if (state._resolve) {
            state._resolve(val);
            state._resolve = null;
        }
    };

    return { state, confirm, respond };
}
