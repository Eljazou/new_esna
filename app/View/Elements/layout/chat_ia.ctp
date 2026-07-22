<?php
/**
 * Floating "Chat with IA" launcher + Bootstrap 5 modal.
 *
 * Extracted from app/View/Layouts/default.ctp (Step 2) so the layout stays
 * readable and every page shares one definition. Markup is unchanged from the
 * working Metronic version -- only the indentation was reduced.
 *
 * Rendered by the layout via: $this->element('layout/chat_ia');
 */
?>
<button id="open-chat-ia" class="fixed-botton btn btn-primary btn-lg">
    <?php echo $this->Html->image('ai-white.svg', ['alt' => 'AI Icon', 'style' => 'width: 20px; height: 20px; margin-right: 10px;']); ?>
    Chat with IA
</button>

<!-- Modal chat IA (Bootstrap 5 markup) -->
<div class="modal fade" id="chat-ia-modal" tabindex="-1" aria-labelledby="chatIAModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="chatIAModalLabel">Chat with IA</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 387px;">
                <div class="card">
                    <div class="card-body">
                        <div id="ia-chat-messages" style="height: 300px; overflow-y: auto;">
                            <div class="d-flex flex-column mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">IA Assistant</span>
                                    <span class="text-muted fs-8">Maintenant</span>
                                </div>
                                <div>Bonjour, comment puis-je vous aider aujourd'hui?</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form id="ia-chat-form">
                            <div class="input-group">
                                <input type="text" id="ia-chat-input" name="message"
                                    placeholder="Écrivez votre message..." class="form-control">
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
