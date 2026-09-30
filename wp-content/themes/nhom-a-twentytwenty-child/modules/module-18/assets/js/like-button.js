(function () {
	'use strict';

	function initializeLikeButtons() {
		if (typeof window.module18Like !== 'object') {
			return;
		}

		document.querySelectorAll('[data-module18-like]').forEach(function (container) {
			var button = container.querySelector('[data-module18-like-button]');

			if (!button) {
				return;
			}

			var label = container.querySelector('[data-module18-like-label]');
			var count = container.querySelector('[data-module18-like-count]');
			var message = container.querySelector('[data-module18-like-message]');

			button.addEventListener('click', function () {
				if (button.disabled) {
					return;
				}

				button.disabled = true;
				button.setAttribute('aria-busy', 'true');
				message.textContent = '';
				message.classList.remove('module18-message-error', 'module18-message-success');

				var requestBody = new URLSearchParams();
				requestBody.append('action', window.module18Like.action);
				requestBody.append('nonce', window.module18Like.nonce);
				requestBody.append('post_id', button.getAttribute('data-post-id'));

				fetch(window.module18Like.ajaxUrl, {
					method: 'POST',
					credentials: 'same-origin',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
					},
					body: requestBody.toString()
				})
					.then(function (response) {
						return response.json().catch(function () {
							throw new Error(window.module18Like.messages.invalidResponse);
						}).then(function (payload) {
							if (!response.ok || !payload.success) {
								var errorData = payload && payload.data ? payload.data : {};
								var error = new Error(errorData.message || window.module18Like.messages.requestFailed);
								error.loginRequired = Boolean(errorData.loginRequired);
								error.loginUrl = errorData.loginUrl || window.module18Like.loginUrl;
								throw error;
							}

							return payload.data;
						});
					})
					.then(function (data) {
						var isLiked = Boolean(data.liked);

						button.setAttribute('aria-pressed', isLiked ? 'true' : 'false');
						container.classList.toggle('module18-is-liked', isLiked);
						label.textContent = data.label;
						count.textContent = data.countText;
						message.textContent = data.message;
						message.classList.add('module18-message-success');
					})
					.catch(function (error) {
						if (error.loginRequired && error.loginUrl) {
							var loginLink = document.createElement('a');
							loginLink.className = 'module18-inline-login-link';
							loginLink.href = error.loginUrl;
							loginLink.textContent = window.module18Like.messages.loginAction;
							message.textContent = window.module18Like.messages.loginRequired + ' ';
							message.appendChild(loginLink);
						} else {
							message.textContent = error.message || window.module18Like.messages.requestFailed;
						}

						message.classList.add('module18-message-error');
					})
					.then(function () {
						button.disabled = false;
						button.removeAttribute('aria-busy');
					});
			});
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initializeLikeButtons);
	} else {
		initializeLikeButtons();
	}
}());
