export const initBeanspaBeforeAfterSample = () => {
    const debugTag = "[BeforeAfterSample]";
    const section = document.querySelector(".beanspa-before-after-sample");

    if (! section || section.classList.contains("js-ba-inited")) {
        console.warn(debugTag, "skip init", {
            hasSection: Boolean(section),
            alreadyInited: Boolean(section && section.classList.contains("js-ba-inited")),
        });

        return;
    }

    section.classList.add("js-ba-inited");
    console.info(debugTag, "init start");

    const firstInner = section.querySelector(".ba-card-inner");

    if (firstInner) {
        const styles = window.getComputedStyle(firstInner);

        console.info(debugTag, "css check", {
            display: styles.display,
            gridTemplateColumns: styles.gridTemplateColumns,
            borderRadius: styles.borderRadius,
        });
    }

    const clamp = (num, min, max) => Math.max(min, Math.min(max, num));

    const initCompare = (container) => {
        const before = container.querySelector(".ba-before");

        if (! before) {
            console.warn(debugTag, "compare init skipped: no before layer");

            return;
        }

        let separator = container.querySelector(".ba-separator");
        let handle = container.querySelector(".ba-handle");

        if (! separator) {
            separator = document.createElement("div");
            separator.className = "ba-separator";
            container.appendChild(separator);
        }

        if (! handle) {
            handle = document.createElement("div");
            handle.className = "ba-handle";
            handle.innerHTML = '<span class="ba-left-arrow"></span><span class="ba-right-arrow"></span>';
            container.appendChild(handle);
        }

        const initialPosition = Number(container.dataset.start || 0.5);
        let position = Number.isFinite(initialPosition) ? clamp(initialPosition, 0.06, 0.94) : 0.5;
        let dragging = false;
        let activePointerId = null;
        let activeTouchId = null;
        let dragSource = null;
        let moveLogCount = 0;
        const compareId = container.dataset.compareId || Math.random().toString(36).slice(2, 8);

        container.dataset.compareId = compareId;

        const dragLog = (label, payload = {}) => {
            console.log(debugTag, `[compare:${compareId}] ${label}`, payload);
        };

        handle.setAttribute("tabindex", "0");
        handle.setAttribute("role", "slider");
        handle.setAttribute("aria-label", "So sanh truoc va sau");
        handle.setAttribute("aria-valuemin", "6");
        handle.setAttribute("aria-valuemax", "94");

        const render = () => {
            const pct = position * 100;

            container.style.setProperty("--ba-pos", `${pct}%`);
            before.style.clipPath = `inset(0 ${100 - pct}% 0 0)`;
            separator.style.left = `${pct}%`;
            handle.style.left = `${pct}%`;
            handle.setAttribute("aria-valuenow", `${Math.round(pct)}`);
        };

        const updateFromClientX = (clientX) => {
            const rect = container.getBoundingClientRect();

            if (! rect.width) {
                dragLog("update skipped: zero width", {
                    width: rect.width,
                    height: rect.height,
                });

                return;
            }

            const next = (clientX - rect.left) / rect.width;
            position = clamp(next, 0.06, 0.94);
            render();
        };

        const onPointerMove = (event) => {
            if (! dragging || event.pointerId !== activePointerId) {
                if (dragging && event.pointerId !== activePointerId) {
                    dragLog("pointermove ignored: pointer mismatch", {
                        activePointerId,
                        eventPointerId: event.pointerId,
                    });
                }

                return;
            }

            updateFromClientX(event.clientX);

            moveLogCount += 1;

            if (moveLogCount <= 6 || moveLogCount % 12 === 0) {
                dragLog("pointermove", {
                    moveLogCount,
                    pointerId: event.pointerId,
                    clientX: event.clientX,
                    position,
                });
            }
        };

        const stopDragging = (event) => {
            if (! dragging) {
                return;
            }

            if (
                dragSource === "pointer"
                && event.pointerId !== undefined
                && event.pointerId !== activePointerId
            ) {
                dragLog("stop ignored: pointer mismatch", {
                    activePointerId,
                    eventPointerId: event.pointerId,
                    eventType: event.type,
                });

                return;
            }

            dragLog("stop dragging", {
                eventType: event.type,
                dragSource,
                pointerId: event.pointerId,
                finalPosition: position,
                moveLogCount,
            });

            dragging = false;
            container.classList.remove("is-dragging");

            if (activePointerId !== null && container.hasPointerCapture(activePointerId)) {
                container.releasePointerCapture(activePointerId);
            }

            activePointerId = null;
            activeTouchId = null;
            dragSource = null;
        };

        const startDragging = (event) => {
            if (event.button !== undefined && event.button !== 0) {
                dragLog("start ignored: non-primary button", {
                    button: event.button,
                    pointerId: event.pointerId,
                    pointerType: event.pointerType,
                });

                return;
            }

            if (dragging) {
                dragLog("start ignored: already dragging", {
                    activePointerId,
                    eventPointerId: event.pointerId,
                    dragSource,
                });

                return;
            }

            activePointerId = event.pointerId;
            dragSource = "pointer";
            dragging = true;
            moveLogCount = 0;
            container.classList.add("is-dragging");
            container.setPointerCapture(activePointerId);
            updateFromClientX(event.clientX);

            dragLog("start dragging", {
                pointerId: event.pointerId,
                pointerType: event.pointerType,
                clientX: event.clientX,
                width: container.getBoundingClientRect().width,
                position,
            });

            event.preventDefault();
        };

        const startMouseDragging = (event) => {
            if (event.button !== 0 || dragging) {
                return;
            }

            dragSource = "mouse";
            dragging = true;
            moveLogCount = 0;
            container.classList.add("is-dragging");
            updateFromClientX(event.clientX);

            dragLog("start mouse dragging", {
                clientX: event.clientX,
                buttons: event.buttons,
            });

            event.preventDefault();
        };

        const onMouseMove = (event) => {
            if (! dragging || dragSource !== "mouse") {
                return;
            }

            updateFromClientX(event.clientX);
            moveLogCount += 1;

            if (moveLogCount <= 6 || moveLogCount % 12 === 0) {
                dragLog("mousemove", {
                    moveLogCount,
                    clientX: event.clientX,
                    position,
                });
            }
        };

        const startTouchDragging = (event) => {
            if (dragging || ! event.changedTouches.length) {
                return;
            }

            const touch = event.changedTouches[0];

            activeTouchId = touch.identifier;
            dragSource = "touch";
            dragging = true;
            moveLogCount = 0;
            container.classList.add("is-dragging");
            updateFromClientX(touch.clientX);

            dragLog("start touch dragging", {
                touchId: activeTouchId,
                clientX: touch.clientX,
            });

            event.preventDefault();
        };

        const onTouchMove = (event) => {
            if (! dragging || dragSource !== "touch") {
                return;
            }

            const touch = Array.from(event.changedTouches)
                .find((item) => item.identifier === activeTouchId);

            if (! touch) {
                return;
            }

            updateFromClientX(touch.clientX);
            moveLogCount += 1;

            if (moveLogCount <= 6 || moveLogCount % 12 === 0) {
                dragLog("touchmove", {
                    moveLogCount,
                    touchId: activeTouchId,
                    clientX: touch.clientX,
                    position,
                });
            }

            event.preventDefault();
        };

        const stopTouchDragging = (event) => {
            if (! dragging || dragSource !== "touch") {
                return;
            }

            const hasActiveTouch = Array.from(event.changedTouches)
                .some((item) => item.identifier === activeTouchId);

            if (! hasActiveTouch) {
                return;
            }

            stopDragging(event);
        };

        container.addEventListener("pointerdown", startDragging);
        container.addEventListener("pointermove", onPointerMove, { passive: true });
        container.addEventListener("pointerup", stopDragging, { passive: true });
        container.addEventListener("pointercancel", stopDragging, { passive: true });
        container.addEventListener("lostpointercapture", (event) => {
            dragLog("lostpointercapture", {
                pointerId: event.pointerId,
                activePointerId,
                dragging,
            });

            stopDragging(event);
        }, { passive: true });

        container.addEventListener("mousedown", startMouseDragging);
        window.addEventListener("mousemove", onMouseMove, { passive: true });
        window.addEventListener("mouseup", stopDragging, { passive: true });
        container.addEventListener("touchstart", startTouchDragging, { passive: false });
        container.addEventListener("touchmove", onTouchMove, { passive: false });
        container.addEventListener("touchend", stopTouchDragging, { passive: true });
        container.addEventListener("touchcancel", stopTouchDragging, { passive: true });

        dragLog("listeners attached", {
            hasPointerEvent: Boolean(window.PointerEvent),
        });

        handle.addEventListener("keydown", (event) => {
            const step = event.shiftKey ? 0.05 : 0.02;

            if (event.key === "ArrowLeft") {
                position = clamp(position - step, 0.06, 0.94);
                render();
                event.preventDefault();
            }

            if (event.key === "ArrowRight") {
                position = clamp(position + step, 0.06, 0.94);
                render();
                event.preventDefault();
            }
        });

        render();

        console.info(debugTag, "compare ready", {
            width: container.getBoundingClientRect().width,
            height: container.getBoundingClientRect().height,
        });
    };

    const initStackScroll = () => {
        const cards = Array.from(section.querySelectorAll(".ba-card"));

        console.info(debugTag, "stack cards found", cards.length);

        cards.forEach((card, index) => {
            card.style.paddingTop = `${20 + index * 20}px`;
        });

        const onScroll = () => {
            const viewportH = window.innerHeight;

            cards.forEach((card, index) => {
                if (index === cards.length - 1) {
                    return;
                }

                const inner = card.querySelector(".ba-card-inner");
                const nextCard = cards[index + 1];

                if (! inner || ! nextCard) {
                    return;
                }

                const offsetTop = 20 + index * 20;
                const triggerStart = viewportH - card.clientHeight;
                const triggerEnd = offsetTop;
                const nextY = nextCard.getBoundingClientRect().top;

                const progress = clamp(
                    (triggerStart - nextY) / Math.max(1, triggerStart - triggerEnd),
                    0,
                    1
                );
                const toScale = 1 - (cards.length - 1 - index) * 0.05;
                const scale = 1 - (1 - toScale) * progress;
                const brightness = 1 - 0.4 * progress;

                inner.style.transform = `scale(${scale})`;
                inner.style.filter = `brightness(${brightness})`;
            });
        };

        onScroll();
        window.addEventListener("scroll", onScroll, { passive: true });
        window.addEventListener("resize", onScroll, { passive: true });

        console.info(debugTag, "stack scroll ready");
    };

    try {
        const compareItems = section.querySelectorAll(".ba-compare");

        console.info(debugTag, "compare items found", compareItems.length);

        compareItems.forEach(initCompare);
        initStackScroll();

        console.info(debugTag, "init done");
    } catch (error) {
        console.error(debugTag, "init failed", error);
    }
};
