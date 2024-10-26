<script>
    window.DeviceTracker = {
        config: @json([
            'current' => $fingerprint,
            'transport' => $transport,
        ])
    };
</script>
<script>
    if (window.DeviceTracker.config.current === null) {
        const fpPromise = import('https://openfpcdn.io/fingerprintjs/v4')
            .then(FingerprintJS => FingerprintJS.load())

        fpPromise
            .then(fp => fp.get())
            .then(result => {
                const transport = window.DeviceTracker.config.transport

                window.DeviceTracker.config.current = result.visitorId
                document.cookie = `${transport.key}=${result.visitorId}; expires=Fri, 31 Dec 9999 23:59:59 GMT; domain=${location.hostname}; SameSite=Lax;`
            })
            .catch(error => console.error(error))
    }
</script>
