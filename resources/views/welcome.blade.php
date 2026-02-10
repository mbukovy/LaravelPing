<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
    @verbatim
    <div id="app" class="w-full max-w-sm">
        <form @submit.prevent="send" class="bg-white rounded-xl shadow-lg p-6 space-y-4">
            <label for="uuid" class="block text-sm font-medium text-slate-700 mb-1">UUID</label>
            <input id="uuid" v-model="uuid" type="text" placeholder="e.g. device-uuid-123" required
                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-400 focus:border-slate-400 outline-none transition">

            <label for="battery_percent" class="block text-sm font-medium text-slate-700 mb-1">Battery %</label>
            <input id="battery_percent" v-model.number="batteryPercent" type="number" min="0" max="100" placeholder="0–100" required
                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-400 focus:border-slate-400 outline-none transition">

            <button type="submit" :disabled="sending"
                class="w-full mt-2 py-2.5 px-4 bg-slate-800 text-white font-medium rounded-lg hover:bg-slate-700 disabled:opacity-60 disabled:cursor-not-allowed transition">
                Send
            </button>
        </form>

        <div v-if="message !== null"
            :class="[
                'mt-4 p-3 rounded-lg text-sm',
                message.success ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'
            ]">
            {{ message.text }}
        </div>
    </div>
    @endverbatim

    <script>
        const {
            createApp
        } = Vue;
        createApp({
            data() {
                return {
                    uuid: '',
                    batteryPercent: null,
                    sending: false,
                    message: null,
                };
            },
            methods: {
                async send() {
                    this.message = null;
                    this.sending = true;
                    try {
                        const res = await fetch('/api/ping', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                uuid: this.uuid,
                                battery_percent: this.batteryPercent,
                            }),
                        });
                        const data = await res.json().catch(() => ({}));
                        if (res.ok) {
                            this.message = {
                                text: 'Sent.',
                                success: true
                            };
                            this.uuid = '';
                            this.batteryPercent = null;
                        } else {
                            const errors = data.errors ? Object.values(data.errors).flat() : [data.message || 'Request failed'];
                            this.message = {
                                text: errors.join(' '),
                                success: false
                            };
                        }
                    } catch (err) {
                        this.message = {
                            text: err.message || 'Network error',
                            success: false
                        };
                    } finally {
                        this.sending = false;
                    }
                },
            },
        }).mount('#app');
    </script>
</body>

</html>