document.addEventListener('DOMContentLoaded', () => {
    const treeContainer = document.getElementById('treeContainer');
    
    // Fetch and render tree
    const bustCacheUrl = treeApiUrl + (treeApiUrl.includes('?') ? '&' : '?') + 't=' + new Date().getTime();
    fetch(bustCacheUrl)
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                treeContainer.innerHTML = `<div class="empty-state">${data.error}</div>`;
                return;
            }
            
            // Flatten tree by depth
            const generations = {};
            window.allTreeMembers = [];
            const visitedIds = new Set();
            
            function traverse(node, depth) {
                if (visitedIds.has(node.id)) return;
                visitedIds.add(node.id);
                
                // Gunakan generasi manual jika ada, jika tidak fallback ke hitungan otomatis (depth + 1)
                let genIndex = node.generasi ? (parseInt(node.generasi) - 1) : depth;
                
                if (!generations[genIndex]) generations[genIndex] = [];
                generations[genIndex].push(node);
                window.allTreeMembers.push(node);
                
                if (node.children && node.children.length > 0) {
                    node.children.forEach(child => traverse(child, depth + 1));
                }
            }
            
            if (Array.isArray(data)) {
                data.forEach(root => traverse(root, 0));
            } else {
                traverse(data, 0);
            }
            
            renderGenerations(generations);
        })
        .catch(err => {
            treeContainer.innerHTML = `<div class="empty-state">Gagal memuat data silsilah.</div>`;
            console.error(err);
        });

    // Fitur Pencarian (Client-side)
    const searchInput = document.querySelector('.silsilah-search-box input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.member-card');
            
            cards.forEach(card => {
                // Ambil semua nama (individu & pasangan) dalam card tersebut
                const names = Array.from(card.querySelectorAll('.profile-name')).map(n => n.textContent.toLowerCase());
                const matches = names.some(name => name.includes(term));
                
                card.style.display = matches ? 'block' : 'none';
            });
            
            // Sembunyikan baris generasi jika semua card di dalamnya tersembunyi
            document.querySelectorAll('.generation-row').forEach(row => {
                const visibleCards = row.querySelectorAll('.member-card[style="display: block;"], .member-card:not([style*="display: none"])');
                row.style.display = visibleCards.length === 0 ? 'none' : 'flex';
            });
        });
    }

    function renderGenerations(generations) {
        treeContainer.innerHTML = '';
        
        const genKeys = Object.keys(generations).map(Number).sort((a,b)=>a-b);
        
        if (genKeys.length === 0) {
            treeContainer.innerHTML = `
                <div class="empty-state" style="text-align: center; padding: 40px;">
                    Belum ada data silsilah keluarga.
                    <br><br>
                    <a href="${treeApiUrl.replace('get_family_tree', 'add')}" class="btn-tambah-anggota" style="display: inline-block; padding: 10px 20px; background: var(--accent); color: white; border-radius: 8px; text-decoration: none;">+ Tambah Anggota Pertama</a>
                </div>`;
            return;
        }

        genKeys.forEach(depth => {
            const members = generations[depth];
            
            // Determine Generation Name
            let genName = 'Generasi ' + (depth + 1);
            let genSub = '';
            if (depth === 0) genSub = 'Keluarga Pendiri';
            else if (depth === 1) genSub = 'Anak';
            else if (depth === 2) genSub = 'Cucu';
            else if (depth === 3) genSub = 'Cicit';
            else if (depth === 4) genSub = 'Piut';
            
            const totalIndividu = members.reduce((acc, m) => acc + 1 + (m.pasangan ? m.pasangan.length || 1 : 0), 0);
            const totalKeluarga = members.length;
            
            const rowHtml = `
                <div class="generation-row">
                    <div class="generation-info">
                        <div>
                            <h3 class="gen-title">${genName}</h3>
                            <p class="gen-subtitle">${genSub}</p>
                            <div class="gen-stats">
                                <i class="bi bi-people"></i> ${totalKeluarga} Keluarga
                            </div>
                            <div class="gen-stats" style="margin-top:4px;">
                                <i class="bi bi-person"></i> ${totalIndividu} Individu
                            </div>
                        </div>
                    </div>
                    <div class="generation-cards" style="flex: 1; align-items: center;">
                        ${members.map(m => renderMemberCard(m)).join('')}
                    </div>
                    <div class="generation-add-btn-container" style="display: flex; align-items: center; justify-content: center; width: 80px; flex-shrink: 0; background: var(--cream); border-left: 1px dashed var(--line);">
                        <button class="btn-add-gen" onclick="addGenerationMember(${depth + 1})" title="Tambah Anggota ${genName}" style="width: 50px; height: 50px; border-radius: 50%; background: transparent; border: 2px solid var(--accent); color: var(--accent); font-size: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; opacity: 0.8;" onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)';" onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)';">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            `;
            
            treeContainer.insertAdjacentHTML('beforeend', rowHtml);
        });

        // Add event listeners to cards
        document.querySelectorAll('.member-card').forEach(card => {
            card.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                openModal(id);
            });
        });
        
        document.querySelectorAll('.clickable-profile').forEach(col => {
            col.addEventListener('click', function(e) {
                e.stopPropagation();
                const id = this.getAttribute('data-id');
                if (id) openModal(id);
            });
        });
    }

    function renderMemberCard(member) {
        let profilesHtml = '';
        
        profilesHtml += `
            <div class="profile-col clickable-profile" data-id="${member.id}">
                <img src="${member.foto}" class="profile-img" alt="${member.nama}">
                <div class="profile-name">${member.nama.split(' ')[0]}</div>
            </div>
        `;
        
        if (member.pasangan) {
            if (Array.isArray(member.pasangan)) {
                member.pasangan.forEach(p => {
                    profilesHtml += `
                        <div class="profile-col clickable-profile" data-id="${p.id}">
                            <img src="${p.foto}" class="profile-img" alt="${p.nama}">
                            <div class="profile-name">${p.nama.split(' ')[0]}</div>
                        </div>
                    `;
                });
            } else {
                profilesHtml += `
                    <div class="profile-col clickable-profile" data-id="${member.pasangan.id}">
                        <img src="${member.pasangan.foto}" class="profile-img" alt="${member.pasangan.nama}">
                        <div class="profile-name">${member.pasangan.nama.split(' ')[0]}</div>
                    </div>
                `;
            }
        }
        
        const anakCount = member.children ? member.children.length : 0;
        const footerHtml = `<div class="card-footer"><i class="bi bi-people"></i> ${anakCount} Anak <i class="bi bi-chevron-right" style="font-size:10px; margin-left:4px;"></i></div>`;
        
        return `
            <div class="member-card" data-id="${member.id}">
                <div class="member-card-profiles">
                    ${profilesHtml}
                </div>
                ${footerHtml}
            </div>
        `;
    }

    // Modal Logic
    const modal = document.getElementById('infoPopup');
    const btnClose = document.getElementById('popupClose');
    const btnTutup = document.getElementById('btnTutupModal');
    
    function closeModal() {
        modal.classList.remove('open');
    }
    
    btnClose.addEventListener('click', closeModal);
    btnTutup.addEventListener('click', closeModal);
    
    // Close on click outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Tab Logic
    const tabs = document.querySelectorAll('.modal-tab');
    const panes = document.querySelectorAll('.tab-pane');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active from all
            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.classList.remove('active'));
            
            // Add active to clicked
            tab.classList.add('active');
            const target = tab.getAttribute('data-target');
            document.getElementById(target).classList.add('active');
        });
    });

    function openModal(id) {
        // Show loading state (optional)
        document.getElementById('modalName').innerText = 'Memuat...';
        modal.classList.add('open');
        
        // Reset tabs to first tab
        tabs[0].click();

        const bustCacheUrl = detailApiUrl + '?id=' + id + '&t=' + new Date().getTime();
        fetch(bustCacheUrl)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    closeModal();
                    return;
                }
                populateModal(data);
            })
            .catch(err => {
                console.error(err);
                alert("Gagal memuat detail.");
                closeModal();
            });
    }

    function populateModal(data) {
        // Edit Button Logic
        const btnEdit = document.getElementById('btnEditModal');
        if (btnEdit) {
            const role = window.currentUserRole;
            const currentUserId = window.currentUserId;
            if (role === 'admin' || role === 'super_admin' || (data.created_by && data.created_by == currentUserId)) {
                btnEdit.style.display = 'inline-block';
                btnEdit.href = '#';
                btnEdit.onclick = function(e) {
                    e.preventDefault();
                    if (window.openEditModal) window.openEditModal(data);
                };
            } else {
                btnEdit.style.display = 'none';
                btnEdit.onclick = null;
            }
        }

        // Header
        document.getElementById('modalPhoto').src = data.foto;
        document.getElementById('modalName').innerText = data.nama;
        document.getElementById('modalGenerationLabel').innerText = `${data.generasi_label} • ${data.gender === 'L' ? 'Laki-laki' : 'Perempuan'}`;

        // Tab Individu
        const infoItems = [
            { icon: 'geo-alt', label: 'Tempat Lahir', value: data.tempat_lahir || '-' },
            { icon: 'gender-ambiguous', label: 'Jenis Kelamin', value: data.gender === 'L' ? 'Laki-laki' : 'Perempuan' },
            { icon: 'briefcase', label: 'Pekerjaan', value: data.pekerjaan || '-' },
            { icon: 'moon-stars', label: 'Agama', value: data.agama || '-' },
            { icon: 'person', label: 'Ayah', value: data.ayah_name || '-' },
            { icon: 'person', label: 'Ibu', value: data.ibu_name || '-' },
            { icon: 'heart', label: data.pasangan_label || 'Pasangan', value: data.pasangan_name || '-' },
            { icon: 'people', label: 'Anak', value: data.jumlah_anak || '-' },
            { icon: 'telephone', label: 'No. Telp', value: data.telepon || '-' },
            { icon: 'envelope', label: 'Email', value: data.email || '-' },
            { icon: 'activity', label: 'Status', value: data.status || '-' },
            { icon: 'house', label: 'Alamat', value: data.tempat_tinggal || '-' }
        ];

        if (data.is_alive === 0) {
            infoItems.push({ icon: 'geo-fill text-brand-medium', label: 'Tempat Makam', value: 'Makam Keluarga H. M. Samhudi' });
        }

        let htmlIndividu = '';
        infoItems.forEach(item => {
            htmlIndividu += `
                <div class="info-label"><i class="bi bi-${item.icon}"></i> ${item.label}</div>
                <div class="info-value">${item.value}</div>
            `;
        });
        document.getElementById('infoListIndividu').innerHTML = htmlIndividu;

        // Tab Keluarga (Tampilkan lengkap untuk semua generasi)
        let htmlKeluargaInfo = `
            <div class="info-label"><i class="bi bi-person"></i> Nama ${data.pasangan_label || 'Pasangan'}</div>
            <div class="info-value mb-2">${data.pasangan_name || '-'}</div>
            
            <div class="info-label"><i class="bi bi-people"></i> Jumlah Anak</div>
            <div class="info-value mb-2">${data.jumlah_anak || '-'}</div>
            
            <div class="info-label"><i class="bi bi-person"></i> Ayah</div>
            <div class="info-value mb-2">${data.ayah_name || '-'}</div>
            
            <div class="info-label"><i class="bi bi-person"></i> Ibu</div>
            <div class="info-value mb-2">${data.ibu_name || '-'}</div>
            
            <div class="info-label"><i class="bi bi-sort-numeric-down"></i> Anak ke</div>
            <div class="info-value mb-2">${data.anak_ke || '-'} dari ${data.dari_jumlah_saudara || '-'} bersaudara</div>
        `;
        document.getElementById('infoListKeluargaInfo').innerHTML = htmlKeluargaInfo;

        // Family Cards (Istri, Anak, Ortua, Saudara)
        let htmlCards = '';
        
        if (data.pasangan && data.pasangan.length > 0) {
            htmlCards += renderSubCardGroup(data.pasangan_label || 'Pasangan', data.pasangan);
        }
        if (data.anak_anak && data.anak_anak.length > 0) {
            htmlCards += renderSubCardGroup('Anak-anak', data.anak_anak);
        }
        if (data.orang_tua && data.orang_tua.length > 0) {
            htmlCards += renderSubCardGroup('Orang Tua', data.orang_tua);
        }
        if (data.saudara && data.saudara.length > 0) {
            htmlCards += renderSubCardGroup('Saudara', data.saudara);
        }

        htmlCards += renderMiniTree(data);

        document.getElementById('familyCardsSection').innerHTML = htmlCards;
    }

    function renderSubCardGroup(title, membersArray) {
        let html = `<div class="sub-card-group"><div class="sub-card-title">${title}</div>`;
        membersArray.forEach(m => {
            html += `
                <div class="sub-card" onclick="openModal(${m.id})" style="cursor: pointer;">
                    <img src="${m.foto}" alt="${m.nama}">
                    <div class="sub-card-info">
                        <h4>${m.nama}</h4>
                        <p>${m.generasi_info || m.hubungan}</p>
                    </div>
                </div>
            `;
        });
        html += `</div>`;
        return html;
    }

    function renderMiniTree(data) {
        let html = `
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h4 class="text-sm font-bold text-center mb-6 text-[color:var(--ink)]" style="font-family: 'Manuale', serif;">
                <i class="bi bi-diagram-3 mr-1"></i> Pohon Keluarga Inti
            </h4>
            <div class="flex flex-col items-center w-full pb-4">
        `;
            
        if (data.orang_tua && data.orang_tua.length > 0) {
            html += `<div class="flex justify-center gap-4 relative z-10 w-full">`;
            data.orang_tua.forEach(ot => {
                html += `
                    <div class="flex flex-col items-center w-20 cursor-pointer transition-transform hover:scale-105" onclick="openModal(${ot.id})">
                        <img src="${ot.foto}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 shadow-sm mb-1 bg-white">
                        <span class="text-[10px] text-[color:var(--ink)] text-center leading-tight line-clamp-2 font-semibold mt-1">${ot.nama}</span>
                        <span class="text-[9px] text-[color:var(--text-muted)]">${ot.hubungan}</span>
                    </div>
                `;
            });
            html += `</div>`;
            html += `<div class="w-px h-6 bg-gray-300 mx-auto relative z-0"></div>`;
        }

        html += `<div class="flex justify-center items-start gap-6 relative z-10 w-full">`;
        html += `
            <div class="flex flex-col items-center w-24 relative z-10">
                <img src="${data.foto}" class="w-14 h-14 rounded-full object-cover border-[3px] border-amber-500 shadow-md mb-1 bg-white">
                <span class="text-[11px] text-[color:var(--ink)] font-bold text-center leading-tight line-clamp-2 mt-1">${data.nama}</span>
                <span class="text-[9px] text-amber-600 font-bold">Diri Sendiri</span>
            </div>
        `;
        if (data.pasangan && data.pasangan.length > 0) {
            data.pasangan.forEach(pas => {
                html += `
                    <div class="flex flex-col items-center w-24 cursor-pointer transition-transform hover:scale-105 relative z-10" onclick="openModal(${pas.id})">
                        <img src="${pas.foto}" class="w-12 h-12 rounded-full object-cover border-2 border-emerald-500 shadow-sm mb-1 bg-white">
                        <span class="text-[11px] text-[color:var(--ink)] font-semibold text-center leading-tight line-clamp-2 mt-1">${pas.nama}</span>
                        <span class="text-[9px] text-emerald-600">${pas.hubungan}</span>
                    </div>
                `;
            });
            html += `<div class="absolute top-7 left-1/2 transform -translate-x-1/2 w-24 border-t-2 border-gray-300 z-0"></div>`;
        }
        html += `</div>`;

        if (data.anak_anak && data.anak_anak.length > 0) {
            html += `<div class="w-px h-6 bg-gray-300 mx-auto relative z-0"></div>`;
            
            if (data.anak_anak.length > 1) {
                html += `<div class="w-full max-w-[80%] border-t-2 border-gray-300 mx-auto relative z-0" style="height: 10px; border-left: 2px solid #d1d5db; border-right: 2px solid #d1d5db; border-bottom: 0;"></div>`;
            } else {
                html += `<div class="w-px h-2 bg-gray-300 mx-auto relative z-0"></div>`;
            }
            
            html += `<div class="flex justify-center gap-3 relative z-10 flex-wrap w-full">`;
            data.anak_anak.forEach(anak => {
                html += `
                    <div class="flex flex-col items-center w-16 cursor-pointer transition-transform hover:scale-105 relative" onclick="openModal(${anak.id})">
                        <img src="${anak.foto}" class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 shadow-sm mb-1 bg-white">
                        <span class="text-[10px] text-[color:var(--ink)] text-center leading-tight line-clamp-2 font-medium mt-1">${anak.nama}</span>
                        <span class="text-[9px] text-[color:var(--text-muted)]">${anak.hubungan}</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        html += `</div></div>`;
        return html;
    }

    // Handle add generation member
    window.addGenerationMember = function(generasi) {
        window.location.href = treeApiUrl.replace('get_family_tree', 'add') + '?generasi=' + generasi;
    };

    window.switchTab = function(tab) {
        document.getElementById('tabBesar').style.borderBottomColor = 'transparent';
        document.getElementById('tabBesar').style.color = '#8fa398';
        document.getElementById('tabBesar').classList.remove('active-tab');
        
        const tabInti = document.getElementById('tabInti');
        if (tabInti) {
            tabInti.style.borderBottomColor = 'transparent';
            tabInti.style.color = '#8fa398';
            tabInti.classList.remove('active-tab');
        }

        if (tab === 'besar') {
            document.getElementById('tabBesar').style.borderBottomColor = 'var(--accent, #d4af37)';
            document.getElementById('tabBesar').style.color = 'var(--accent, #d4af37)';
            document.getElementById('tabBesar').classList.add('active-tab');
            document.getElementById('treeContainer').style.display = 'block';
            document.getElementById('intiContainer').style.display = 'none';
        } else {
            if (tabInti) {
                tabInti.style.borderBottomColor = 'var(--accent, #d4af37)';
                tabInti.style.color = 'var(--accent, #d4af37)';
                tabInti.classList.add('active-tab');
            }
            document.getElementById('treeContainer').style.display = 'none';
            document.getElementById('intiContainer').style.display = 'block';
            renderKeluargaInti();
        }
    };

    function renderKeluargaInti() {
        const container = document.getElementById('intiCards');
        if (!container) return;
        
        if (!window.currentUserId) {
            container.innerHTML = '<p style="color: var(--ink-soft); width: 100%; text-align: center;">Silakan login untuk melihat Keluarga Inti.</p>';
            return;
        }

        const myMembers = window.allTreeMembers.filter(m => String(m.created_by) === String(window.currentUserId));
        
        if (myMembers.length === 0) {
            container.innerHTML = '<p style="color: var(--ink-soft); width: 100%; text-align: center;">Anda belum menambahkan data kerabat satupun.</p>';
            return;
        }

        let html = myMembers.map(m => renderMemberCard(m)).join('');
        
        html += `
            <div class="member-card" style="display: flex; align-items: center; justify-content: center; background: transparent; border: 2px dashed var(--accent, #d4af37); cursor: pointer; min-height: 160px; min-width: 250px; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(212, 175, 55, 0.1)';" onmouseout="this.style.background='transparent';" onclick="window.addGenerationMember('')">
                <div style="text-align: center; color: var(--accent, #d4af37);">
                    <i class="bi bi-plus-circle" style="font-size: 2.5rem; margin-bottom: 10px; display: block;"></i>
                    <span style="font-weight: bold; font-size: 15px;">Tambah Keluarga</span>
                </div>
            </div>
        `;

        container.innerHTML = html;

        // Add event listeners to cards
        container.querySelectorAll('.member-card').forEach(card => {
            card.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (id) openModal(id);
            });
        });
        
        container.querySelectorAll('.clickable-profile').forEach(col => {
            col.addEventListener('click', function(e) {
                e.stopPropagation();
                const id = this.getAttribute('data-id');
                if (id) openModal(id);
            });
        });
    }

    window.closeEditModal = function() {
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.style.display = 'none';
            editModal.setAttribute('aria-hidden', 'true');
        }
    };

    window.openEditModal = function(data) {
        // Hide infoPopup
        closeModal();
        
        const editModal = document.getElementById('editModal');
        if (!editModal) return;
        
        // Set form action
        document.getElementById('editForm').action = window.editMemberUrl + '/' + data.id;
        
        // Populate fields from data.raw_data
        const raw = data.raw_data;
        if (raw) {
            document.getElementById('editFullName').value = raw.full_name || '';
            document.getElementById('editGender').value = raw.gender || 'L';
            document.getElementById('editGenerasi').value = raw.generasi || '';
            document.getElementById('editBirthPlace').value = raw.birth_place || '';
            document.getElementById('editBirthDate').value = raw.birth_date ? raw.birth_date.split(' ')[0] : '';
            document.getElementById('editIsAlive').value = raw.is_alive == 0 ? '0' : '1';
            
            const deathContainer = document.getElementById('editDeathDateContainer');
            if (raw.is_alive == 0) {
                deathContainer.style.display = 'block';
                document.getElementById('editDeathDate').value = raw.death_date ? raw.death_date.split(' ')[0] : '';
            } else {
                deathContainer.style.display = 'none';
                document.getElementById('editDeathDate').value = '';
            }
            
            // Populate Ayah & Ibu dropdowns
            const fatherSelect = document.getElementById('editFatherId');
            const motherSelect = document.getElementById('editMotherId');
            
            if (fatherSelect && motherSelect && window.allTreeMembers) {
                let fatherHtml = '<option value="">-- Pilih Ayah --</option>';
                let motherHtml = '<option value="">-- Pilih Ibu --</option>';
                
                window.allTreeMembers.forEach(m => {
                    if (m.id == data.id) return; // Cannot be parent of self
                    if (m.gender === 'L') {
                        const sel = (raw.father_id == m.id) ? 'selected' : '';
                        fatherHtml += `<option value="${m.id}" ${sel}>${m.nama} (Gen ${m.generasi || '?'})</option>`;
                    } else if (m.gender === 'P') {
                        const sel = (raw.mother_id == m.id) ? 'selected' : '';
                        motherHtml += `<option value="${m.id}" ${sel}>${m.nama} (Gen ${m.generasi || '?'})</option>`;
                    }
                });
                
                fatherSelect.innerHTML = fatherHtml;
                motherSelect.innerHTML = motherHtml;
            }
            
            document.getElementById('editPhone').value = raw.phone || '';
            document.getElementById('editEmail').value = raw.email || '';
            document.getElementById('editOccupation').value = raw.occupation || '';
            document.getElementById('editAddress').value = raw.address || '';
        }
        
        editModal.style.display = 'flex';
        editModal.removeAttribute('aria-hidden');
    };
});