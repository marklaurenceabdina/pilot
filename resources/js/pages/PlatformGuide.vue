<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import AppLogo from '@/components/AppLogo.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, Gavel, Users, Lock, Shield, BookOpen } from 'lucide-vue-next';
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-950 via-purple-950 to-slate-950 text-white p-8 relative overflow-hidden">
    <!-- Animated Background Grid -->
    <div class="absolute inset-0 opacity-20">
      <div class="grid-bg"></div>
    </div>
    
    <!-- Floating Particles -->
    <div class="particles">
      <div class="particle" v-for="i in 20" :key="i" :style="{ 
        left: Math.random() * 100 + '%',
        top: Math.random() * 100 + '%',
        animationDelay: Math.random() * 3 + 's',
        animationDuration: (Math.random() * 3 + 2) + 's'
      }"></div>
    </div>

    <!-- Header with Logo + Back -->
    <div class="flex justify-between items-center mb-10 animate-slide-down relative z-10">
      <div class="flex items-center gap-3">
        <div class="relative">
          <AppLogo class="w-10 h-10 drop-shadow-2xl" />
          <div class="absolute inset-0 bg-cyan-400 rounded-full blur-lg opacity-30 animate-pulse"></div>
        </div>
      </div>
      <Link :href="route('dashboard')">
        <Button
          class="cyberpunk-btn group relative overflow-hidden px-6 py-3 bg-gradient-to-r from-cyan-500 to-purple-600 hover:from-cyan-400 hover:to-purple-500 border-0 rounded-lg font-semibold transition-all duration-300"
        >
          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
          <ArrowLeft class="w-4 h-4 mr-2" />
          <span class="relative z-10">Back to Dashboard</span>
        </Button>
      </Link>
    </div>

    <!-- Title + Intro -->
    <div class="text-center mb-16 relative z-10">
      <div class="inline-flex items-center justify-center gap-3 mb-6 animate-glow-pulse">
        <BookOpen class="w-10 h-10 text-cyan-400" />
        <h2 class="text-5xl font-black bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent animate-slide-up">
          PLATFORM GUIDELINES
        </h2>
        <BookOpen class="w-10 h-10 text-pink-400" />
      </div>
      
      <div class="max-w-4xl mx-auto relative">
        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 to-purple-500/10 blur-3xl rounded-full"></div>
        <p class="relative text-slate-300 text-lg leading-relaxed animate-fade-in-delayed backdrop-blur-sm bg-slate-900/30 p-6 rounded-2xl border border-slate-700/50">
          Welcome to <span class="font-bold text-transparent bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text">PSITS NEXUS</span>!  
          As your trusted platform, we've created these guidelines to ensure our space remains safe, inclusive, 
          and productive. By following these rules, we can all enjoy a better community together.
        </p>
      </div>
    </div>

    <!-- Guideline Sections -->
    <div class="grid gap-8 md:grid-cols-2 max-w-7xl mx-auto relative z-10">
      <!-- Prohibited Content -->
      <Card class="cyberpunk-card group" data-delay="0.1">
        <CardHeader class="relative">
          <div class="absolute top-10 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-orange-500 rounded-t-lg"></div>
          <CardTitle class="flex items-center gap-3 text-2xl font-bold text-red-400 group-hover:text-red-300 transition-colors">
            <div class="relative">
              <Gavel class="w-6 h-6" />
              <div class="absolute inset-0 bg-red-500 blur-lg opacity-50 animate-pulse"></div>
            </div>
            Prohibited Content & Behavior
          </CardTitle>
        </CardHeader>
        <CardContent class="text-slate-300 leading-relaxed space-y-4">
          <p class="text-slate-400 font-medium">
            We want PSITS Nexus to be a safe environment. That's why we strictly prohibit the following:
          </p>
          <ul class="space-y-3">
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-red-500/30 hover:border-red-500/60 transition-colors">
              <div class="w-2 h-2 bg-red-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-red-400">Hate speech:</b> Content that promotes violence or discrimination against individuals or groups based on race, ethnicity, religion, gender, sexual orientation, disability, etc.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-red-500/30 hover:border-red-500/60 transition-colors">
              <div class="w-2 h-2 bg-red-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-red-400">Harassment & bullying:</b> Behavior intended to intimidate, threaten, or humiliate others, including doxing (sharing private information without consent).</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-red-500/30 hover:border-red-500/60 transition-colors">
              <div class="w-2 h-2 bg-red-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-red-400">Violence & threats:</b> Any content that glorifies or incites violence, terrorism, or self-harm.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-red-500/30 hover:border-red-500/60 transition-colors">
              <div class="w-2 h-2 bg-red-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-red-400">Illegal activities:</b> Content promoting or discussing illegal acts, such as selling illicit drugs or firearms, or engaging in fraud.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-red-500/30 hover:border-red-500/60 transition-colors">
              <div class="w-2 h-2 bg-red-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-red-400">Spam & scams:</b> Repeated, unsolicited messages, or any fraudulent content designed to deceive users.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-red-500/30 hover:border-red-500/60 transition-colors">
              <div class="w-2 h-2 bg-red-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-red-400">Explicit content:</b> Material that is sexually explicit, graphic, or otherwise not safe for work (NSFW).</div>
            </li>
          </ul>
        </CardContent>
      </Card>

      <!-- UGC Rules -->
      <Card class="cyberpunk-card group" data-delay="0.2">
        <CardHeader class="relative">
          <div class="absolute top-10 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-500 rounded-t-lg"></div>
          <CardTitle class="flex items-center gap-3 text-2xl font-bold text-green-400 group-hover:text-green-300 transition-colors">
            <div class="relative">
              <Users class="w-6 h-6" />
              <div class="absolute inset-0 bg-green-500 blur-lg opacity-50 animate-pulse"></div>
            </div>
            User-Generated Content Rules
          </CardTitle>
        </CardHeader>
        <CardContent class="text-slate-300 leading-relaxed space-y-4">
          <p class="text-slate-400 font-medium">
            Since our platform relies on your contributions, we set clear rules for sharing content:
          </p>
          <ul class="space-y-3">
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-green-500/30 hover:border-green-500/60 transition-colors">
              <div class="w-2 h-2 bg-green-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-green-400">Intellectual property:</b> Users must respect copyright and trademark laws. This means not posting content they don't own or have permission to use.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-green-500/30 hover:border-green-500/60 transition-colors">
              <div class="w-2 h-2 bg-green-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-green-400">Authenticity:</b> We encourage honesty. Don't misrepresent your identity — some cases may even require real names.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-green-500/30 hover:border-green-500/60 transition-colors">
              <div class="w-2 h-2 bg-green-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-green-400">Relevance:</b> Content should always connect with the platform's purpose. Off-topic or unrelated posts may be removed.</div>
            </li>
          </ul>
        </CardContent>
      </Card>

      <!-- Safety & Privacy -->
      <Card class="cyberpunk-card group" data-delay="0.3">
        <CardHeader class="relative">
          <div class="absolute top-10 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-t-lg"></div>
          <CardTitle class="flex items-center gap-3 text-2xl font-bold text-yellow-400 group-hover:text-yellow-300 transition-colors">
            <div class="relative">
              <Lock class="w-6 h-6" />
              <div class="absolute inset-0 bg-yellow-500 blur-lg opacity-50 animate-pulse"></div>
            </div>
            Safety & Privacy
          </CardTitle>
        </CardHeader>
        <CardContent class="text-slate-300 leading-relaxed space-y-4">
          <p class="text-slate-400 font-medium">
            Protecting your safety and privacy is one of our top responsibilities:
          </p>
          <ul class="space-y-3">
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-yellow-500/30 hover:border-yellow-500/60 transition-colors">
              <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-yellow-400">Protection of personal information:</b> Don't share private details such as addresses, phone numbers, or financial data.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-yellow-500/30 hover:border-yellow-500/60 transition-colors">
              <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-yellow-400">Minors' safety:</b> We have zero tolerance for child exploitation. We also enforce age-appropriate protections.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-yellow-500/30 hover:border-yellow-500/60 transition-colors">
              <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-yellow-400">Account security:</b> Keep your account safe with strong passwords and two-factor authentication.</div>
            </li>
          </ul>
        </CardContent>
      </Card>

      <!-- Enforcement -->
      <Card class="cyberpunk-card group" data-delay="0.4">
        <CardHeader class="relative">
          <div class="absolute top-10 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-lg"></div>
          <CardTitle class="flex items-center gap-3 text-2xl font-bold text-blue-400 group-hover:text-blue-300 transition-colors">
            <div class="relative">
              <Shield class="w-6 h-6" />
              <div class="absolute inset-0 bg-blue-500 blur-lg opacity-50 animate-pulse"></div>
            </div>
            Enforcement & Consequences
          </CardTitle>
        </CardHeader>
        <CardContent class="text-slate-300 leading-relaxed space-y-4">
          <p class="text-slate-400 font-medium">
            To keep things fair, here's how we enforce our rules:
          </p>
          <ul class="space-y-3">
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-blue-500/30 hover:border-blue-500/60 transition-colors">
              <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-blue-400">Reporting violations:</b> You can report content or behavior that breaks our guidelines.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-blue-500/30 hover:border-blue-500/60 transition-colors">
              <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-blue-400">Disciplinary actions:</b> Depending on the severity, consequences may include warnings, content removal, temporary suspensions, or permanent bans.</div>
            </li>
            <li class="flex items-start gap-3 p-3 rounded-lg bg-slate-800/30 border-l-2 border-blue-500/30 hover:border-blue-500/60 transition-colors">
              <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 animate-pulse"></div>
              <div><b class="text-blue-400">Appeals process:</b> If you feel a decision was unfair, you have the right to appeal.</div>
            </li>
          </ul>
        </CardContent>
      </Card>
    </div>

    <!-- Closing -->
    <div class="max-w-5xl mx-auto mt-16 text-center relative z-10">
      <div class="relative">
        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 via-purple-500/10 to-pink-500/10 blur-2xl rounded-full"></div>
        <div class="relative backdrop-blur-sm bg-slate-900/40 p-8 rounded-2xl border border-slate-700/50 animate-fade-in-delayed">
          <p class="text-slate-400 text-lg leading-relaxed">
            These guidelines are not just rules, but our promise to you:  
            <span class="font-bold text-transparent bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-xl block mt-2">
              we commit to building a respectful, safe, and inclusive space for every PSITS member.
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Grid Background */
.grid-bg {
  background-image: 
    linear-gradient(rgba(0, 255, 255, 0.1) 1px, transparent 1px),
    linear-gradient(90deg, rgba(0, 255, 255, 0.1) 1px, transparent 1px);
  background-size: 50px 50px;
  width: 100%;
  height: 100%;
  animation: grid-move 20s linear infinite;
}

@keyframes grid-move {
  0% { transform: translate(0, 0); }
  100% { transform: translate(50px, 50px); }
}

/* Floating Particles */
.particles {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 1;
}

.particle {
  position: absolute;
  width: 2px;
  height: 2px;
  background: linear-gradient(45deg, #00ffff, #ff00ff);
  border-radius: 50%;
  animation: float infinite ease-in-out;
  opacity: 0.7;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0; }
  50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
}

/* Animations */
@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes glowPulse {
  0%, 100% { filter: drop-shadow(0 0 5px rgba(0, 255, 255, 0.3)); }
  50% { filter: drop-shadow(0 0 20px rgba(0, 255, 255, 0.6)); }
}

@keyframes cardSlideIn {
  from {
    opacity: 0;
    transform: translateY(50px) rotateX(10deg);
  }
  to {
    opacity: 1;
    transform: translateY(0) rotateX(0deg);
  }
}

/* Animation Classes */
.animate-slide-down {
  animation: slideDown 0.8s ease forwards;
}

.animate-slide-up {
  animation: slideUp 1s ease forwards;
}

.animate-fade-in-delayed {
  animation: fadeIn 1.2s ease forwards 0.5s;
  opacity: 0;
}

.animate-glow-pulse {
  animation: glowPulse 3s ease-in-out infinite;
}

/* Cyberpunk Cards */
.cyberpunk-card {
  background: linear-gradient(135deg, rgba(15, 23, 42, 0.8), rgba(30, 41, 59, 0.6));
  border: 1px solid rgba(148, 163, 184, 0.2);
  border-radius: 1rem;
  backdrop-filter: blur(10px);
  position: relative;
  overflow: hidden;
  animation: cardSlideIn 0.8s ease forwards;
  opacity: 0;
  transition: all 0.3s ease;
}

.cyberpunk-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
  transition: left 0.5s;
}

.cyberpunk-card:hover::before {
  left: 100%;
}

.cyberpunk-card:hover {
  transform: translateY(-5px) scale(1.02);
  border-color: rgba(148, 163, 184, 0.4);
  box-shadow: 
    0 20px 40px rgba(0, 0, 0, 0.4),
    0 0 0 1px rgba(255, 255, 255, 0.1);
}

.cyberpunk-card[data-delay="0.1"] { animation-delay: 0.1s; }
.cyberpunk-card[data-delay="0.2"] { animation-delay: 0.3s; }
.cyberpunk-card[data-delay="0.3"] { animation-delay: 0.5s; }
.cyberpunk-card[data-delay="0.4"] { animation-delay: 0.7s; }

/* Cyberpunk Button */
.cyberpunk-btn {
  position: relative;
  text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
  box-shadow: 
    0 0 20px rgba(0, 255, 255, 0.3),
    inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.cyberpunk-btn:hover {
  box-shadow: 
    0 0 30px rgba(0, 255, 255, 0.5),
    0 0 15px rgba(147, 51, 234, 0.4),
    inset 0 1px 0 rgba(255, 255, 255, 0.3);
  transform: translateY(-2px);
}
</style>