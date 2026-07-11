<!-- ============================================================
     شات بوت PalHomeServices - بنفس التصميم الأصلي تماماً
     انسخي هذا الكود كامل وحطيه قبل </body> مباشرة
     بأي صفحة بدك يظهر فيها الزر فقط
     ============================================================ -->

<style>
  /* الزر العائم */
  #chatToggleBtn {
    position: fixed;
    bottom: 24px;
    left: 24px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #0C7779;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 26px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    z-index: 99998;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
  }
  #chatToggleBtn:hover { transform: scale(1.08); }

  /* خلفية معتمة خلف النافذة */
  #chatOverlayBg {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.35);
    z-index: 99999;
    display: none;
  }
  #chatOverlayBg.open { display: block; }

  /* نفس .chat-container تماماً، بس الآن داخل overlay */
  .chat-container {
    position: fixed;
    bottom: 24px;
    left: 24px;
    width: 420px;
    height: 650px;
    max-height: 85vh;
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.25);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 100000;
    font-family: 'Segoe UI', Tahoma, sans-serif;
  }
  .chat-container.open { display: flex; }

  .chat-header {
    background: #0C7779;
    color: white;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .chat-header .avatar {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }

  .chat-header .header-info h3 { font-size: 15px; font-weight: 600; margin: 0; }
  .chat-header .header-info span { font-size: 12px; opacity: 0.8; }

  .chat-close-btn {
    margin-right: auto;
    background: rgba(255,255,255,0.15);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .chat-close-btn:hover { background: rgba(255,255,255,0.25); }

  .chat-container .messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    direction: rtl;
  }

  .chat-container .messages::-webkit-scrollbar { width: 4px; }
  .chat-container .messages::-webkit-scrollbar-thumb { background: #ddd; border-radius: 4px; }

  .chat-container .msg {
    max-width: 80%;
    padding: 10px 14px;
    border-radius: 14px;
    font-size: 14px;
    line-height: 1.6;
    word-break: break-word;
  }

  .chat-container .msg.user {
    background: #0C7779;
    color: white;
    align-self: flex-start;
    border-bottom-right-radius: 4px;
  }

  .chat-container .msg.bot {
    background: #f1f5f9;
    color: #1e293b;
    align-self: flex-end;
    border-bottom-left-radius: 4px;
  }

  .chat-container .msg.bot strong { color: #0C7779; }

  .chat-container .typing {
    display: flex;
    gap: 4px;
    padding: 12px 16px;
    background: #f1f5f9;
    border-radius: 14px;
    border-bottom-left-radius: 4px;
    align-self: flex-end;
    width: fit-content;
  }

  .chat-container .typing span {
    width: 7px;
    height: 7px;
    background: #94a3b8;
    border-radius: 50%;
    animation: chatBounce 1.2s infinite;
  }

  .chat-container .typing span:nth-child(2) { animation-delay: 0.2s; }
  .chat-container .typing span:nth-child(3) { animation-delay: 0.4s; }

  @keyframes chatBounce {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-6px); }
  }

  .chat-container .suggestions {
    padding: 0 16px 8px;
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    direction: rtl;
  }

  .chat-container .suggestion {
    background: #e8f5f5;
    color: #0C7779;
    border: 1px solid #b2dfdf;
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 12px;
    cursor: pointer;
    font-family: inherit;
  }
  .chat-container .suggestion:hover { background: #0C7779; color: white; }

  .chat-container .input-area {
    padding: 12px 16px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    gap: 8px;
    align-items: center;
    direction: rtl;
  }

  .chat-container .input-area input {
    flex: 1;
    border: 1.5px solid #e2e8f0;
    border-radius: 24px;
    padding: 10px 16px;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    direction: rtl;
  }

  .chat-container .input-area input:focus { border-color: #0C7779; }

  .chat-container .send-btn {
    width: 40px;
    height: 40px;
    background: #0C7779;
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .chat-container .send-btn:hover { background: #0a6163; }
  .chat-container .send-btn:disabled { background: #94a3b8; cursor: not-allowed; }

  .chat-container .welcome {
    text-align: center;
    color: #94a3b8;
    font-size: 13px;
    padding: 20px;
  }
  .chat-container .welcome .icon { font-size: 40px; margin-bottom: 8px; }

  @media (max-width: 480px) {
    .chat-container {
      width: calc(100% - 24px);
      left: 12px;
      right: 12px;
      bottom: 12px;
      height: 80vh;
    }
  }
</style>

<!-- الزر العائم -->
<button id="chatToggleBtn" title="تحدث مع المساعد الذكي">🏠</button>

<!-- خلفية معتمة (اختياري - تقفل الشات لو ضغطتي برا) -->
<div id="chatOverlayBg"></div>

<!-- نفس صندوق الشات الأصلي بالضبط -->
<div class="chat-container" id="chatContainer">
  <div class="chat-header">
    <div class="avatar">🏠</div>
    <div class="header-info">
      <h3>مساعد PalHomeServices</h3>
      <span>متصل الآن</span>
    </div>
    <button class="chat-close-btn" id="chatCloseBtn">✕</button>
  </div>

  <div class="messages" id="chatMessages">
    <div class="welcome">
      <div class="icon">🤖</div>
      <p>مرحباً! أنا مساعدك الذكي.<br>اسألني عن أي خدمة منزلية أو مزود خدمة.</p>
    </div>
  </div>

  <div class="suggestions" id="chatSuggestions">
    <button class="suggestion" data-text="ما هي الخدمات المتاحة؟">ما هي الخدمات المتاحة؟</button>
    <button class="suggestion" data-text="أفضل مزود سباكة">أفضل مزود سباكة</button>
    <button class="suggestion" data-text="خدمات التنظيف وأسعارها">خدمات التنظيف وأسعارها</button>
  </div>

  <div class="input-area">
    <input type="text" id="chatUserInput" placeholder="اكتب سؤالك هنا..." />
    <button class="send-btn" id="chatSendBtn">➤</button>
  </div>
</div>

<script>
(function () {
  const API_URL = "http://localhost:5000";

  let SESSION_ID = sessionStorage.getItem("phs_chat_session");
  if (!SESSION_ID) {
    SESSION_ID = "session_" + Date.now();
    sessionStorage.setItem("phs_chat_session", SESSION_ID);
  }

  const toggleBtn = document.getElementById("chatToggleBtn");
  const closeBtn = document.getElementById("chatCloseBtn");
  const overlayBg = document.getElementById("chatOverlayBg");
  const container = document.getElementById("chatContainer");
  const messagesEl = document.getElementById("chatMessages");
  const inputEl = document.getElementById("chatUserInput");
  const sendBtn = document.getElementById("chatSendBtn");
  const suggestionsEl = document.getElementById("chatSuggestions");

  function openChat() {
    container.classList.add("open");
    overlayBg.classList.add("open");
    inputEl.focus();
  }

  function closeChat() {
    container.classList.remove("open");
    overlayBg.classList.remove("open");
  }

  toggleBtn.addEventListener("click", openChat);
  closeBtn.addEventListener("click", closeChat);
  overlayBg.addEventListener("click", closeChat);

  function formatText(text) {
    return text
      .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
      .replace(/\n/g, "<br>");
  }

  function addMessage(text, role) {
    const welcome = messagesEl.querySelector(".welcome");
    if (welcome) welcome.remove();

    const div = document.createElement("div");
    div.className = `msg ${role}`;
    div.innerHTML = formatText(text);
    messagesEl.appendChild(div);
    messagesEl.scrollTop = messagesEl.scrollHeight;
  }

  function showTyping() {
    const div = document.createElement("div");
    div.className = "typing";
    div.id = "chatTyping";
    div.innerHTML = "<span></span><span></span><span></span>";
    messagesEl.appendChild(div);
    messagesEl.scrollTop = messagesEl.scrollHeight;
  }

  function removeTyping() {
    const t = document.getElementById("chatTyping");
    if (t) t.remove();
  }

  async function sendMessage(text) {
    const msg = (text !== undefined ? text : inputEl.value).trim();
    if (!msg) return;

    suggestionsEl.style.display = "none";
    addMessage(msg, "user");
    inputEl.value = "";
    sendBtn.disabled = true;
    showTyping();

    try {
      const res = await fetch(`${API_URL}/chat`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: msg, session_id: SESSION_ID })
      });
      const data = await res.json();
      removeTyping();
      addMessage(data.reply || "حدث خطأ، حاول مرة ثانية.", "bot");
    } catch (e) {
      removeTyping();
      addMessage("تعذر الاتصال بالخادم. تأكد أن Python شغال.", "bot");
    }

    sendBtn.disabled = false;
    inputEl.focus();
  }

  sendBtn.addEventListener("click", () => sendMessage());
  inputEl.addEventListener("keydown", (e) => {
    if (e.key === "Enter") sendMessage();
  });

  suggestionsEl.querySelectorAll(".suggestion").forEach(b => {
    b.addEventListener("click", () => sendMessage(b.dataset.text));
  });
})();
</script>
